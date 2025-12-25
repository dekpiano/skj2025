// Helper function to determine the correct base path for API calls
function getApiBasePath() {
    // If #grid exists, we are on the main news list page (e.g., /News)
    // If not, we are likely on the detail page (e.g., /News/Detail/123)
    return ($('#grid').length > 0) ? '' : '../';
}

// --- Reusable Search Suggestions Function ---
function setupSearchSuggestions(inputId, listId) {
    const searchInput = $(inputId);
    const suggestionsList = $(listId);
    const form = searchInput.closest('form'); // Get the parent form

    searchInput.on('keyup', function() {
        const searchTerm = $(this).val();
        if (searchTerm.length > 2) {
            $.ajax({
                url: getApiBasePath() + 'news-suggestions', // Dynamic URL
                type: 'GET',
                data: { term: searchTerm },
                dataType: 'json',
                success: function(data) {
                    suggestionsList.empty();
                    if (data.length > 0) {
                        const regex = new RegExp(searchTerm, 'gi');
                        data.forEach(item => {
                            const highlightedText = item.news_topic.replace(regex, `<span class="highlight">$&</span>`);
                            const detailUrl = getApiBasePath() + `News/Detail/${item.news_id}`;
                            suggestionsList.append(`<a href="${detailUrl}" class="list-group-item list-group-item-action">${highlightedText}</a>`);
                        });
                        suggestionsList.show();
                    } else {
                        suggestionsList.hide();
                    }
                }
            });
        } else {
            suggestionsList.hide();
        }
    });

    // Hide suggestions when clicking outside the form
    $(document).on('click', function(e) {
        if (!$(e.target).closest(form).length) {
            suggestionsList.hide();
        }
    });
}

// --- Infinite Scroll Variables and Function ---
let currentPage = 1;
let isLoading = false;
let noMoreData = false;

function fetchData(page) {
    if (isLoading || noMoreData) return;
    isLoading = true;
    $('#loading-spinner').show();

    $.ajax({
        url: 'News/loadMoreNews', // This is only called from the main page, so path is fixed
        type: 'GET',
        data: { page: page },
        dataType: 'json',
        success: function(data) {
            const grid = $('#grid');
            if (data.items.length > 0) {
                data.items.forEach(item => {
                    const gridItem = `
                        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                            <div class="card h-100 shadow-sm">
                                <a href="News/Detail/${item.news_id}" class="CountReadNews" data_view="${item.news_view}" news_id="${item.news_id}">
                                    <img class="card-img-top" src="uploads/news/${item.news_img}" alt="${item.news_topic}">
                                </a>
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">
                                        <a href="News/Detail/${item.news_id}" class="CountReadNews" data_view="${item.news_view}" news_id="${item.news_id}">${item.news_topic}</a>
                                    </h5>
                                    <div class="mt-auto">
                                        <div class="d-flex justify-content-between text-muted small">
                                            <span><i class="fa fa-user me-2"></i>Admin</span>
                                            <span><i class="fa fa-calendar-alt me-2"></i>${item.news_date}</span>
                                            <span><i class="fa fa-eye me-2"></i>${item.news_view}</span>
                                        </div>
                                        <a class="btn btn-primary mt-3 CountReadNews" data_view="${item.news_view}" news_id="${item.news_id}" href="News/Detail/${item.news_id}">อ่านต่อ</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    grid.append(gridItem);
                });

                if ($(document).height() <= $(window).height() && !noMoreData) {
                    currentPage++;
                    fetchData(currentPage);
                } else {
                    isLoading = false;
                    $('#loading-spinner').hide();
                }
            } else {
                noMoreData = true;
                $('#loading-spinner').hide();
            }
        },
        error: function() {
            console.error("Failed to load news.");
            $('#loading-spinner').hide();
            isLoading = false;
        }
    });
}

// --- Document Ready - Main Execution ---
$(document).ready(function() {
    // Setup for main news page search
    if ($('#searchInput').length) {
        setupSearchSuggestions('#searchInput', '#suggestions-list');
    }

    // Setup for sidebar search on detail page
    if ($('#sidebarSearchInput').length) {
        setupSearchSuggestions('#sidebarSearchInput', '#sidebar-suggestions-list');
    }

    // --- Infinite Scroll ---
    if ($('#grid').length) {
        fetchData(currentPage);
        $(window).on('scroll', function() {
            if ($(window).scrollTop() + $(window).height() >= $(document).height() - 200 && !isLoading && !noMoreData) {
                currentPage++;
                fetchData(currentPage);
            }
        });
    }

    // --- Count Read News ---
    $(document).on("click", ".CountReadNews", function() {
        $.post(getApiBasePath() + "CountReadNews", {
            Data_View: $(this).attr('data_view'),
            NewsID: $(this).attr('news_id')
        }, function(data, status) {
            // console.log(data); // Optional: can be removed
        });
    });
});