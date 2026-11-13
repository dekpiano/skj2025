// Helper function to determine the correct base path for API calls
function getApiBasePath() {
    if (typeof BASE_URL !== 'undefined' && BASE_URL) {
        return BASE_URL.endsWith('/') ? BASE_URL : BASE_URL + '/';
    }
    // Fallback if BASE_URL is not globally declared
    return ($('#grid').length > 0) ? '' : '../';
}

// Global Image Loading Handlers (Smooth Shimmer & Spinner to Fade-in)
window.skjOnImageLoad = function(img) {
    if (!img) return;
    img.classList.add('is-loaded');
    const wrapper = img.closest('.news-card-img-wrapper');
    if (wrapper) {
        wrapper.classList.remove('is-loading');
        const loader = wrapper.querySelector('.news-card-img-loader');
        if (loader) {
            loader.style.opacity = '0';
            setTimeout(function() { 
                loader.style.display = 'none'; 
            }, 350);
        }
    }
};

window.skjOnImageError = function(img) {
    if (!img) return;
    img.onerror = null;
    img.src = 'https://placehold.co/600x400/fb7e9c/white?text=SKJ+News';
    window.skjOnImageLoad(img);
};

// --- Reusable Search Suggestions Function ---
function setupSearchSuggestions(inputId, listId) {
    const searchInput = $(inputId);
    const suggestionsList = $(listId);
    const form = searchInput.closest('form'); // Get the parent form

    searchInput.on('keyup', function() {
        const searchTerm = $(this).val().trim();
        if (searchTerm.length > 2) {
            $.ajax({
                url: getApiBasePath() + 'news-suggestions',
                type: 'GET',
                data: { term: searchTerm },
                dataType: 'json',
                success: function(data) {
                    suggestionsList.empty();
                    if (data && data.length > 0) {
                        const regex = new RegExp(searchTerm.replace(/[.*+?^${}()|[\]\\]/g, '\\$&'), 'gi');
                        data.forEach(item => {
                            const highlightedText = item.news_topic.replace(regex, `<span class="highlight">$&</span>`);
                            const detailUrl = item.detail_url || (getApiBasePath() + `News/Detail/${item.news_id}`);
                            suggestionsList.append(`<a href="${detailUrl}" class="list-group-item list-group-item-action">${highlightedText}</a>`);
                        });
                        suggestionsList.show();
                    } else {
                        suggestionsList.hide();
                    }
                },
                error: function() {
                    suggestionsList.hide();
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

    const searchTerm = ($('#searchInput').length > 0) ? ($('#searchInput').val() || '').trim() : '';

    $.ajax({
        url: getApiBasePath() + 'News/loadMoreNews',
        type: 'GET',
        data: { 
            page: page,
            search: searchTerm
        },
        dataType: 'json',
        success: function(data) {
            const grid = $('#grid');
            if (data && data.items && data.items.length > 0) {
                data.items.forEach(item => {
                    // Safe image resolution: prioritize backend-resolved URL (supports remote cloud & local fallback)
                    let imgUrl = item.news_img_url;
                    if (!imgUrl) {
                        if (item.news_img && item.news_img.startsWith('http')) {
                            imgUrl = item.news_img;
                        } else if (item.news_img) {
                            imgUrl = getApiBasePath() + 'uploads/news/' + item.news_img;
                        } else {
                            imgUrl = 'https://placehold.co/600x400/fb7e9c/white?text=SKJ+News';
                        }
                    }

                    const detailUrl = item.detail_url || (getApiBasePath() + 'News/Detail/' + item.news_id);
                    const formattedDate = item.formatted_date || item.news_date || '';
                    const views = Number(item.news_view || 0).toLocaleString();

                    const gridItem = `
                        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                            <div class="news-card shadow-sm">
                                <div class="news-card-img-wrapper is-loading">
                                    <div class="news-card-img-loader">
                                        <div class="loader-spinner"></div>
                                        <span class="loader-text"><i class="bi bi-image me-1"></i>กำลังโหลด...</span>
                                    </div>
                                    <span class="news-card-badge">PR News</span>
                                    <a href="${detailUrl}" class="CountReadNews" data_view="${item.news_view}" news_id="${item.news_id}">
                                        <img class="news-card-img" src="${imgUrl}" alt="${item.news_topic}" loading="lazy"
                                             onload="skjOnImageLoad(this)"
                                             onerror="skjOnImageError(this)">
                                    </a>
                                </div>
                                <div class="news-card-body">
                                    <div class="news-meta">
                                        <span><i class="bi bi-person me-1"></i> Admin</span>
                                        <span><i class="bi bi-calendar3 me-1"></i> ${formattedDate}</span>
                                        <span><i class="bi bi-eye me-1"></i> ${views}</span>
                                    </div>
                                    <a href="${detailUrl}" class="news-card-title CountReadNews" data_view="${item.news_view}" news_id="${item.news_id}">
                                        ${item.news_topic}
                                    </a>
                                    <div class="news-card-footer">
                                        <a class="read-more-link CountReadNews" data_view="${item.news_view}" news_id="${item.news_id}" href="${detailUrl}">
                                            อ่านต่อ <i class="bi bi-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    grid.append(gridItem);
                });

                // Check for already-cached images that might complete synchronously
                grid.find('.news-card-img').each(function() {
                    if (this.complete && this.naturalHeight !== 0) {
                        skjOnImageLoad(this);
                    }
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
                if (grid.children().length === 0) {
                    grid.append(`
                        <div class="col-12 text-center py-5">
                            <div class="text-muted fs-5">
                                <i class="bi bi-search fs-1 d-block mb-3 text-secondary"></i>
                                ไม่พบข้อมูลข่าวสารที่ค้นหา
                            </div>
                        </div>
                    `);
                }
            }
        },
        error: function(xhr, status, error) {
            console.error("Failed to load news.", error);
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

    // --- Infinite Scroll on News Main Page ---
    if ($('#grid').length) {
        fetchData(currentPage);
        $(window).on('scroll', function() {
            if ($(window).scrollTop() + $(window).height() >= $(document).height() - 250 && !isLoading && !noMoreData) {
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
        });
    });
});
