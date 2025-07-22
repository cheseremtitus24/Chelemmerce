document.addEventListener('DOMContentLoaded', () => {
    // Select all carousel wrappers on the page
    const carouselWrappers = document.querySelectorAll('.carousel-wrapper');

    // Initialize each carousel independently
    carouselWrappers.forEach(wrapper => {
        const carousel = wrapper.querySelector('.carousel-container');
        const prevBtn = wrapper.querySelector('.carousel-nav.left');
        const nextBtn = wrapper.querySelector('.carousel-nav.right');
        const indicatorsContainer = wrapper.querySelector('.carousel-indicators');

        const originalSlides = [...carousel.querySelectorAll('img')];
        const slideCount = originalSlides.length;

        // Don't initialize if there's 1 or 0 images
        if (slideCount <= 1) {
            if (indicatorsContainer) indicatorsContainer.classList.add('single-image');
            if (prevBtn) prevBtn.style.display = 'none';
            if (nextBtn) nextBtn.style.display = 'none';
            return;
        }

        // --- State for this specific carousel instance ---
        let currentIndex = 1;
        let isTransitioning = false;
        let slideWidth = 0;
        let isDragging = false;
        let startX = 0;
        let currentTranslate = 0;

        // --- Clone first and last slides for infinite loop effect ---
        const firstClone = originalSlides[0].cloneNode(true);
        const lastClone = originalSlides[slideCount - 1].cloneNode(true);
        carousel.appendChild(firstClone);
        carousel.insertBefore(lastClone, originalSlides[0]);

        // --- Create indicators ---
        for (let i = 0; i < slideCount; i++) {
            const dot = document.createElement('div');
            dot.addEventListener('click', () => goToSlide(i + 1));
            indicatorsContainer.appendChild(dot);
        }

        const setSlideWidth = () => {
            slideWidth = wrapper.clientWidth;
            updatePosition();
        };

        const updatePosition = (animate = false) => {
            carousel.style.transition = animate ? 'transform 0.4s ease-out' : 'none';
            carousel.style.transform = `translateX(-${currentIndex * slideWidth}px)`;
            updateIndicators();
        };

        const updateIndicators = () => {
            const activeIndex = (currentIndex - 1 + slideCount) % slideCount;
            [...indicatorsContainer.children].forEach((dot, idx) => {
                dot.classList.toggle('active', idx === activeIndex);
            });
        };

        const goToSlide = (index) => {
            if (isTransitioning) return;
            isTransitioning = true;
            currentIndex = index;
            updatePosition(true);
        };

        const handleTransitionEnd = () => {
            isTransitioning = false;
            if (currentIndex === 0) {
                currentIndex = slideCount;
                updatePosition();
            } else if (currentIndex === slideCount + 1) {
                currentIndex = 1;
                updatePosition();
            }
        };

        // --- Dragging Logic ---
        const getPositionX = (e) => (e.type.includes('mouse') ? e.pageX : e.touches[0].pageX);

        const dragStart = (e) => {
            if (isTransitioning) return;
            isDragging = true;
            startX = getPositionX(e);
            carousel.style.transition = 'none';
            currentTranslate = -currentIndex * slideWidth;
            wrapper.style.cursor = 'grabbing';
        };

        const drag = (e) => {
            if (!isDragging) return;
            const currentX = getPositionX(e);
            const diff = currentX - startX;
            carousel.style.transform = `translateX(${currentTranslate + diff}px)`;
        };

        const dragEnd = () => {
            if (!isDragging) return;
            isDragging = false;
            wrapper.style.cursor = 'grab';

            const finalTransform = window.getComputedStyle(carousel).transform;
            const finalTranslate = new DOMMatrix(finalTransform).m41;

            const movedBy = finalTranslate - currentTranslate;
            const threshold = slideWidth / 5; // Swipe sensitivity

            if (movedBy < -threshold) goToSlide(currentIndex + 1);
            else if (movedBy > threshold) goToSlide(currentIndex - 1);
            else updatePosition(true); // Snap back
        };

        // --- Add Event Listeners ---
        prevBtn.addEventListener('click', () => goToSlide(currentIndex - 1));
        nextBtn.addEventListener('click', () => goToSlide(currentIndex + 1));
        carousel.addEventListener('transitionend', handleTransitionEnd);

        wrapper.addEventListener('mousedown', dragStart);
        wrapper.addEventListener('mousemove', drag);
        document.addEventListener('mouseup', dragEnd); // Use document to catch mouseup outside wrapper
        wrapper.addEventListener('mouseleave', dragEnd);

        wrapper.addEventListener('touchstart', dragStart, { passive: true });
        wrapper.addEventListener('touchmove', drag, { passive: true });
        wrapper.addEventListener('touchend', dragEnd);

        window.addEventListener('resize', setSlideWidth);
        setSlideWidth(); // Initial setup
    });
});
