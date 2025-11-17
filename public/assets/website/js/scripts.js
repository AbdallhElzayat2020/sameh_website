// Mobile Menu Toggle
document.addEventListener('DOMContentLoaded', function () {
    const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
    const navLinks = document.querySelector('.nav-links');

    if (mobileMenuToggle && navLinks) {
        mobileMenuToggle.addEventListener('click', function () {
            navLinks.classList.toggle('active');

            // Animate hamburger icon
            const spans = mobileMenuToggle.querySelectorAll('span');
            if (navLinks.classList.contains('active')) {
                spans[0].style.transform = 'rotate(45deg) translateY(8px)';
                spans[1].style.opacity = '0';
                spans[2].style.transform = 'rotate(-45deg) translateY(-8px)';
            } else {
                spans[0].style.transform = 'none';
                spans[1].style.opacity = '1';
                spans[2].style.transform = 'none';
            }
        });

        // Close menu when clicking on a link
        const links = navLinks.querySelectorAll('a');
        links.forEach(link => {
            link.addEventListener('click', function () {
                navLinks.classList.remove('active');
                const spans = mobileMenuToggle.querySelectorAll('span');
                spans[0].style.transform = 'none';
                spans[1].style.opacity = '1';
                spans[2].style.transform = 'none';
            });
        });

        // Close menu when clicking outside
        document.addEventListener('click', function (event) {
            if (!mobileMenuToggle.contains(event.target) && !navLinks.contains(event.target)) {
                navLinks.classList.remove('active');
                const spans = mobileMenuToggle.querySelectorAll('span');
                spans[0].style.transform = 'none';
                spans[1].style.opacity = '1';
                spans[2].style.transform = 'none';
            }
        });
    }

    // Services Section Interaction
    const serviceItems = document.querySelectorAll('.service-item');
    const serviceTitle = document.getElementById('service-title');
    const serviceDescription = document.getElementById('service-description');

    const updateServicePanel = item => {
        if (!item) {
            return;
        }

        const title = item.dataset.title || item.textContent.trim();
        const description = item.dataset.description || '';

        if (serviceTitle) {
            serviceTitle.textContent = title;
        }

        if (serviceDescription) {
            serviceDescription.textContent = description;
        }
    };

    if (serviceItems.length > 0) {
        updateServicePanel(serviceItems[0]);
        serviceItems[0].classList.add('active');

        serviceItems.forEach(item => {
            item.addEventListener('click', function () {
                serviceItems.forEach(service => service.classList.remove('active'));
                this.classList.add('active');
                updateServicePanel(this);
            });
        });
    }

    // Industries Section Interaction
    const industryFilterBtns = document.querySelectorAll('.industry-filter-btn');
    const industryVisualTitle = document.getElementById('industry-visual-title');
    const industryServicesTitle = document.getElementById('industry-services-title');
    const industryServicesList = document.getElementById('industry-services-list');
    const industryDescriptionText = document.getElementById('industry-description-text');
    const industryDescriptionList = document.getElementById('industry-description-list');

    // Get industries data from window (passed from Blade)
    const industriesData = window.industriesData || [];

    // Convert industries array to object keyed by slug for easy lookup
    const industryDataMap = {};
    industriesData.forEach(industry => {
        industryDataMap[industry.slug] = {
            title: industry.name.toUpperCase(),
            visualTitle: industry.name,
            services: industry.options || [],
            description: industry.description || '',
            items: industry.options || [],
            image: industry.image || null
        };
    });

    function updateIndustryContent(industrySlug) {
        const data = industryDataMap[industrySlug];
        if (!data) {
            console.warn('Industry not found:', industrySlug);
            return;
        }

        // Update background image
        const industryVisualPlaceholder = document.getElementById('industry-visual-placeholder');

        if (industryVisualPlaceholder) {
            if (data.image) {
                industryVisualPlaceholder.style.backgroundImage = `url('${data.image}')`;
                industryVisualPlaceholder.style.backgroundSize = 'cover';
                industryVisualPlaceholder.style.backgroundPosition = 'center';
                industryVisualPlaceholder.style.backgroundRepeat = 'no-repeat';
            } else {
                industryVisualPlaceholder.style.backgroundImage = 'none';
            }
        }

        if (industryVisualTitle) {
            industryVisualTitle.textContent = data.visualTitle;
        }
        if (industryServicesTitle) {
            industryServicesTitle.textContent = data.title;
        }
        if (industryServicesList) {
            if (data.services && data.services.length > 0) {
                industryServicesList.innerHTML = data.services.map(service => `
                    <li class="industry-service-item">
                        <span class="service-arrow">→</span>
                        <span>${service}</span>
                    </li>
                `).join('');
            } else {
                industryServicesList.innerHTML = '<li class="industry-service-item"><span class="text-muted">No options available</span></li>';
            }
        }
        if (industryDescriptionText) {
            industryDescriptionText.textContent = data.description || 'Description will be available soon.';
        }
        if (industryDescriptionList) {
            if (data.items && data.items.length > 0) {
                industryDescriptionList.innerHTML = data.items.map(item => `
                    <li>${item}</li>
                `).join('');
            } else {
                industryDescriptionList.innerHTML = '<li class="text-muted">No items available</li>';
            }
        }
    }

    if (industryFilterBtns.length > 0) {
        industryFilterBtns.forEach(btn => {
            btn.addEventListener('click', function () {
                // Remove active class from all buttons
                industryFilterBtns.forEach(b => b.classList.remove('active'));

                // Add active class to clicked button
                this.classList.add('active');

                // Get industry slug from data attribute
                const industrySlug = this.getAttribute('data-industry');
                updateIndustryContent(industrySlug);
            });
        });
    }

    // Testimonials Swiper
    const testimonialsSwiper = document.getElementById('testimonialsSwiper');
    if (testimonialsSwiper) {
        const swiper = new Swiper('.testimonials-swiper', {
            slidesPerView: 1,
            spaceBetween: 20,
            centeredSlides: true,
            loop: true,
            watchOverflow: true,
            slideToClickedSlide: false,
            speed: 600,
            simulateTouch: true,
            touchEventsTarget: 'container',
            touchRatio: 1,
            touchAngle: 45,
            grabCursor: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
                pauseOnMouseEnter: true,
            },
            breakpoints: {
                320: {
                    slidesPerView: 1,
                    spaceBetween: 10,
                    centeredSlides: true,
                },
                576: {
                    slidesPerView: 1,
                    spaceBetween: 15,
                    centeredSlides: true,
                },
                768: {
                    slidesPerView: 1.2,
                    spaceBetween: 20,
                    centeredSlides: true,
                },
                992: {
                    slidesPerView: 3,
                    spaceBetween: 20,
                    centeredSlides: true,
                },
            },
            navigation: {
                nextEl: '.testimonial-next',
                prevEl: '.testimonial-prev',
            },
            on: {
                init: function () {
                    updateCardStyles(this);
                },
                slideChange: function () {
                    updateCardStyles(this);
                },
            },
        });

        function updateCardStyles(swiperInstance) {
            const slides = swiperInstance.slides;
            slides.forEach((slide) => {
                const card = slide.querySelector('.testimonial-card');
                if (card) {
                    if (slide.classList.contains('swiper-slide-active')) {
                        card.classList.add('active');
                        card.style.background = 'var(--text-white)';
                        card.style.opacity = '1';
                        card.style.transform = 'scale(1)';
                    } else {
                        card.classList.remove('active');
                        card.style.background = 'rgba(42, 52, 65, 0.6)';
                        card.style.opacity = '0.5';
                        card.style.transform = 'scale(0.9)';
                    }
                }
            });
        }

        // Update nav buttons styling
        const prevBtn = document.querySelector('.testimonial-prev');
        const nextBtn = document.querySelector('.testimonial-next');

        if (prevBtn && nextBtn) {
            // Next button is always active (blue)
            nextBtn.classList.add('active');

            // Update on slide change
            swiper.on('slideChange', function () {
                prevBtn.classList.remove('active');
                nextBtn.classList.add('active');
            });
        }
    }

    // Price Request Button
    const priceRequestBtn = document.querySelector('.price-request-circle-btn');
    if (priceRequestBtn) {
        priceRequestBtn.addEventListener('click', function () {
            // You can add your price request logic here
            // For example: open a modal, scroll to contact form, etc.
            console.log('Price request clicked');

            // Example: Scroll to contact form
            const contactSection = document.getElementById('contact');
            if (contactSection) {
                contactSection.scrollIntoView({ behavior: 'smooth' });
            }
        });
    }
});

