document.addEventListener('DOMContentLoaded', () => {

    const listingsContainer = document.getElementById('listings-container');
    const loadingSpinner = document.getElementById('loading-spinner');

    // --- STATE MANAGEMENT ---
    let currentPage = 1;
    let isLoading = false;
    let hasMorePages = true;
    const loadedPages = new Set(); // Use a Set for efficient add/has/delete operations
    const MAX_PAGES_IN_DOM = 3;

    // --- UTILITY FUNCTIONS ---
    /**
     * Extracts search query parameters from the current URL.
     * This ensures that pagination requests include the active search filters.
     */
    const getSearchParams = () => {
        const params = new URLSearchParams(window.location.search);
        return params.toString();
    };

    /**
     * Initializes carousels within a given container (or the whole document).
     * This MUST be called every time new content is added to the DOM.
     * @param {HTMLElement} container - The element to search for new carousels within.
     */
    const initializeCarousels = (container) => {
        const carouselWrappers = container.querySelectorAll('.carousel-wrapper');
        carouselWrappers.forEach(wrapper => {
            if (wrapper.dataset.initialized) return; // Prevent re-initializing

            const container = wrapper.querySelector('.carousel-container');
            const leftBtn = wrapper.querySelector('.carousel-nav.left');
            const rightBtn = wrapper.querySelector('.carousel-nav.right');
            const indicatorsContainer = wrapper.querySelector('.carousel-indicators');
            const images = container.querySelectorAll('img');
            let currentIndex = 0;

            if (images.length <= 1) {
                leftBtn.style.display = 'none';
                rightBtn.style.display = 'none';
                return;
            }

            // Create indicators
            indicatorsContainer.innerHTML = '';
            images.forEach((_, i) => {
                const indicator = document.createElement('span');
                indicator.classList.add('indicator');
                if (i === 0) indicator.classList.add('active');
                indicator.addEventListener('click', () => {
                    currentIndex = i;
                    updateCarousel();
                });
                indicatorsContainer.appendChild(indicator);
            });
            const indicators = indicatorsContainer.querySelectorAll('.indicator');

            const updateCarousel = () => {
                container.style.transform = `translateX(-${currentIndex * 100}%)`;
                indicators.forEach((ind, i) => {
                    ind.classList.toggle('active', i === currentIndex);
                });
            };

            leftBtn.addEventListener('click', () => {
                currentIndex = (currentIndex > 0) ? currentIndex - 1 : images.length - 1;
                updateCarousel();
            });

            rightBtn.addEventListener('click', () => {
                currentIndex = (currentIndex < images.length - 1) ? currentIndex + 1 : 0;
                updateCarousel();
            });

            wrapper.dataset.initialized = 'true';
        });
    };

    /**
     * The core function to fetch a page of listings from the server.
     * @param {number} pageToFetch - The page number to request.
     * @param {boolean} prepend - If true, inserts content at the top. Otherwise, appends.
     */
    const loadListings = async (pageToFetch, prepend = false) => {
        if (isLoading || (loadedPages.has(pageToFetch) && !prepend) || !hasMorePages) return;

        isLoading = true;
        if (!prepend) loadingSpinner.style.display = 'block';

        const searchParams = getSearchParams();
        const url = `/home?page=${pageToFetch}&${searchParams}`;

        try {
            const response = await fetch(url);
            if (response.status === 204) { // No More Content
                hasMorePages = false;
                loadingSpinner.innerHTML = 'No more results.';
                return;
            }
            if (!response.ok) throw new Error('Network response was not ok');

            const newContentHTML = await response.text();
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = newContentHTML;
            const newPageWrapper = tempDiv.firstElementChild;

            if (newPageWrapper && newPageWrapper.classList.contains('page-wrapper')) {
                // Manage which pages are in the DOM
                if (prepend) {
                    listingsContainer.prepend(newPageWrapper);
                    loadedPages.add(pageToFetch);
                    // If we now have MORE than max pages, remove the one at the end
                    if (loadedPages.size > MAX_PAGES_IN_DOM) {
                        const lastPageNum = Math.max(...loadedPages);
                        const pageToRemove = listingsContainer.querySelector(`.page-wrapper[data-page="${lastPageNum}"]`);
                        if(pageToRemove) pageToRemove.remove();
                        loadedPages.delete(lastPageNum);
                    }
                } else {
                    listingsContainer.append(newPageWrapper);
                    loadedPages.add(pageToFetch);
                    // If we now have MORE than max pages, remove the one at the beginning
                    if (loadedPages.size > MAX_PAGES_IN_DOM) {
                        const firstPageNum = Math.min(...loadedPages);
                        const pageToRemove = listingsContainer.querySelector(`.page-wrapper[data-page="${firstPageNum}"]`);
                        if(pageToRemove) pageToRemove.remove();
                        loadedPages.delete(firstPageNum);
                    }
                }

                // IMPORTANT: Initialize carousels on the new content
                initializeCarousels(newPageWrapper);

                if(!prepend) currentPage++;
            }

        }
        catch (error) {
            console.error('Failed to fetch listings:', error);
            loadingSpinner.innerHTML = 'Failed to load results.';
        }
        finally {
            isLoading = false;
            if(!prepend) loadingSpinner.style.display = 'none';
        }
    };
    // function checkIfNearTop() {
    //     const firstPageWrapper = listingsContainer.querySelector('.page-wrapper');
    //     const containerTop = scrollContainer.scrollTop;
    //
    //     if (firstPageWrapper) {
    //         const wrapperOffsetTop = firstPageWrapper.offsetTop;
    //
    //         const distanceFromTop = wrapperOffsetTop - containerTop;
    //
    //         if (distanceFromTop <= 150) { // near top of container
    //             const firstPageInDom = Math.min(...loadedPages);
    //             const prevPage = firstPageInDom - 1;
    //
    //             if (prevPage > 0 && !loadedPages.has(prevPage)) {
    //                 loadListings(prevPage, true); // Prepend
    //             }
    //         }
    //     }
    // }
    // const scrollContainer = document.querySelector('.your-scroll-container');
    //
    // scrollContainer.addEventListener('scroll', checkIfNearTop);
    //

    // --- EVENT LISTENERS ---
    const handleScroll = () => {
        // Load more when scrolling down
        const isNearBottom = window.innerHeight + window.scrollY >= document.documentElement.scrollHeight - 300;
        if (isNearBottom) {
            loadListings(currentPage);
        }
        console.log('ScrollY:', window.scrollY, 'Loaded:', [...loadedPages]);
        // Pre-fetch previous page when scrolling up to the top
        const isNearTop = window.scrollY < 200;
        if (isNearTop) {
            const firstPageInDom = Math.min(...loadedPages);
            if (firstPageInDom > 1) {
                loadListings(firstPageInDom - 1, true); // `true` for prepend
            }
        }

// Load previous page when first page is near the top of viewport
//         const firstPageWrapper = listingsContainer.querySelector('.page-wrapper');
//         if (firstPageWrapper) {
//             const rect = firstPageWrapper.getBoundingClientRect();
//
//             // Sticky bar is 100px tall; trigger loading when close to it
//             if (rect.top >= 0 && rect.top > 116) {
//                 const firstPageInDom = Math.min(...loadedPages);
//                 const prevPage = firstPageInDom - 1;
//
//                 if (prevPage > 0 && !loadedPages.has(prevPage)) {
//                     loadListings(prevPage, true); // Prepend previous page
//                 }
//             }
//         }


    };

    window.addEventListener('scroll', handleScroll, { passive: true });
    // --- INITIAL LOAD ---
    // Load the first page when the document is ready.
    loadListings(1);
});
