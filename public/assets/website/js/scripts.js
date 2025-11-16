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

	const serviceData = {
		translation: {
			title: 'TRANSLATION',
			description: 'AI Artificial Intelligence is a branch of computer science that focuses on the development of intelligent machines that can perform tasks that typically require human intelligence.'
		},
		transcription: {
			title: 'TRANSCRIPTION',
			description: 'Professional transcription services that convert audio and video content into accurate written text, ensuring high quality and precision for all your documentation needs.'
		},
		transcreation: {
			title: 'TRANSCREATION',
			description: 'Creative translation services that adapt your content culturally and linguistically, maintaining the original message while resonating with your target audience.'
		},
		'video-audio': {
			title: 'VIDEO & AUDIO TRANSLATION',
			description: 'Comprehensive translation services for multimedia content, including subtitles, dubbing, and voice-over solutions for video and audio materials.'
		},
		machine: {
			title: 'MACHINE TRANSLATION',
			description: 'Advanced machine translation solutions powered by AI technology, providing fast and efficient translation services for large volumes of content.'
		},
		design: {
			title: 'CREATE DESIGN FROM SCRATCH',
			description: 'Complete design services from concept to execution, creating visually stunning and functional designs tailored to your brand and business needs.'
		},
		elearning: {
			title: 'ELEARNING LOCALIZATION',
			description: 'Specialized localization services for e-learning platforms, ensuring educational content is culturally appropriate and linguistically accurate for global learners.'
		},
		game: {
			title: 'GAME LOCALIZATION',
			description: 'Expert game localization services that adapt gaming content, including storylines, dialogues, and UI elements, for international markets.'
		},
		website: {
			title: 'WEBSITE LOCALIZATION',
			description: 'Complete website localization services that translate and adapt your web content, ensuring seamless user experience across different languages and cultures.'
		},
		app: {
			title: 'WEBSITE & APP LOCALIZATION',
			description: 'Comprehensive localization solutions for both websites and mobile applications, providing multilingual support and cultural adaptation for global audiences.'
		},
		software: {
			title: 'SOFTWARE LOCALIZATION',
			description: 'Professional software localization services that translate and adapt software interfaces, documentation, and user guides for international markets.'
		},
		ai: {
			title: 'AI POWERED TRANSLATION',
			description: 'Cutting-edge AI-powered translation services that combine machine learning with human expertise to deliver accurate, context-aware translations at scale.'
		}
	};

	if (serviceItems.length > 0) {
		// Set first service as active by default
		serviceItems[0].classList.add('active');

		serviceItems.forEach(item => {
			item.addEventListener('click', function () {
				// Remove active class from all items
				serviceItems.forEach(service => service.classList.remove('active'));

				// Add active class to clicked item
				this.classList.add('active');

				// Get service data
				const serviceType = this.getAttribute('data-service');
				const data = serviceData[serviceType];

				if (data && serviceTitle && serviceDescription) {
					serviceTitle.textContent = data.title;
					serviceDescription.textContent = data.description;
				}
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

	const industryData = {
		gaming: {
			title: 'GAMING',
			visualTitle: 'Gaming',
			services: [
				'Strategic Business',
				'Growth Consulting',
				'ProfitPath Consultants',
				'Elevate Business',
				'Success Minds',
				'Vision Advisors'
			],
			description: 'Game localization is our primary focus and specialty. We specialize in translating a diverse range of gaming materials, including:',
			items: [
				'AAA Game Titles and Descriptions',
				'In-Game Dialogue and Scripts',
				'User Interfaces and Menus',
				'Game Manuals and Guides',
				'Gaming Websites and Forums',
				'Marketing Materials for Games',
				'Patch Notes and Updates',
				'Localization of Gaming Apps'
			]
		},
		technology: {
			title: 'TECHNOLOGY',
			visualTitle: 'Technology',
			services: [
				'Software Development',
				'Cloud Solutions',
				'IT Consulting',
				'Digital Transformation',
				'Tech Support',
				'Innovation Labs'
			],
			description: 'Technology industry solutions tailored to your business needs. We provide comprehensive services including:',
			items: [
				'Software Localization',
				'Technical Documentation',
				'API Documentation',
				'User Guides',
				'Technical Support Materials',
				'Product Specifications',
				'Training Materials',
				'Technical Marketing Content'
			]
		},
		finance: {
			title: 'FINANCE',
			visualTitle: 'Finance',
			services: [
				'Financial Planning',
				'Investment Advisory',
				'Risk Management',
				'Wealth Management',
				'Corporate Finance',
				'Financial Analysis'
			],
			description: 'Financial services localization with precision and accuracy. Our services include:',
			items: [
				'Financial Reports Translation',
				'Investment Documents',
				'Compliance Materials',
				'Banking Documentation',
				'Insurance Policies',
				'Financial Statements',
				'Regulatory Documents',
				'Market Analysis Reports'
			]
		},
		government: {
			title: 'GOVERNMENT',
			visualTitle: 'Government',
			services: [
				'Public Policy',
				'Administrative Services',
				'Legal Documentation',
				'Regulatory Compliance',
				'Public Relations',
				'Government Relations'
			],
			description: 'Government sector translation services with certified accuracy. We handle:',
			items: [
				'Official Documents',
				'Legislative Materials',
				'Public Notices',
				'Government Forms',
				'Policy Documents',
				'Regulatory Guidelines',
				'Public Information',
				'Administrative Procedures'
			]
		},
		legal: {
			title: 'LEGAL',
			visualTitle: 'Legal',
			services: [
				'Legal Consulting',
				'Contract Review',
				'Litigation Support',
				'Compliance Services',
				'Legal Research',
				'Documentation Services'
			],
			description: 'Legal translation services with certified translators. We specialize in:',
			items: [
				'Legal Contracts',
				'Court Documents',
				'Patents and Trademarks',
				'Legal Briefs',
				'Compliance Documents',
				'Legal Opinions',
				'Regulatory Filings',
				'Legal Correspondence'
			]
		},
		sciences: {
			title: 'SCIENCES',
			visualTitle: 'Sciences',
			services: [
				'Research Support',
				'Scientific Documentation',
				'Laboratory Services',
				'Data Analysis',
				'Scientific Publishing',
				'Research Consulting'
			],
			description: 'Scientific translation with technical accuracy. Our services include:',
			items: [
				'Research Papers',
				'Scientific Journals',
				'Laboratory Reports',
				'Technical Specifications',
				'Scientific Presentations',
				'Research Proposals',
				'Data Sheets',
				'Scientific Documentation'
			]
		},
		marketing: {
			title: 'MARKETING',
			visualTitle: 'Marketing',
			services: [
				'Brand Strategy',
				'Digital Marketing',
				'Content Creation',
				'Market Research',
				'Advertising Campaigns',
				'Social Media Management'
			],
			description: 'Marketing translation that resonates with your target audience. We provide:',
			items: [
				'Marketing Materials',
				'Advertising Copy',
				'Brand Guidelines',
				'Social Media Content',
				'Press Releases',
				'Marketing Campaigns',
				'Product Descriptions',
				'Marketing Presentations'
			]
		},
		ecommerce: {
			title: 'E-COMMERCE',
			visualTitle: 'E-Commerce',
			services: [
				'Online Store Setup',
				'Payment Solutions',
				'Inventory Management',
				'Customer Service',
				'Digital Marketing',
				'E-commerce Consulting'
			],
			description: 'E-commerce localization for global markets. Our services include:',
			items: [
				'Product Descriptions',
				'Shopping Cart Content',
				'Customer Reviews',
				'E-commerce Websites',
				'Payment Pages',
				'Shipping Information',
				'Return Policies',
				'Customer Support Content'
			]
		},
		elearning: {
			title: 'E-LEARNING',
			visualTitle: 'E-Learning',
			services: [
				'Course Development',
				'Learning Management',
				'Educational Content',
				'Training Programs',
				'Assessment Tools',
				'Educational Consulting'
			],
			description: 'E-learning localization for educational platforms. We specialize in:',
			items: [
				'Course Materials',
				'Educational Videos',
				'Interactive Content',
				'Assessment Questions',
				'Learning Modules',
				'Training Manuals',
				'Educational Websites',
				'Student Resources'
			]
		},
		medical: {
			title: 'MEDICAL',
			visualTitle: 'Medical',
			services: [
				'Medical Consulting',
				'Healthcare Services',
				'Clinical Research',
				'Medical Documentation',
				'Healthcare IT',
				'Medical Training'
			],
			description: 'Medical translation with certified healthcare translators. We handle:',
			items: [
				'Medical Records',
				'Clinical Trials',
				'Medical Device Documentation',
				'Pharmaceutical Materials',
				'Patient Information',
				'Medical Reports',
				'Healthcare Websites',
				'Medical Training Materials'
			]
		}
	};

	function updateIndustryContent(industryKey) {
		const data = industryData[industryKey];
		if (!data) return;

		if (industryVisualTitle) {
			industryVisualTitle.textContent = data.visualTitle;
		}
		if (industryServicesTitle) {
			industryServicesTitle.textContent = data.title;
		}
		if (industryServicesList) {
			industryServicesList.innerHTML = data.services.map(service => `
        <li class="industry-service-item">
          <span class="service-arrow">→</span>
          <span>${service}</span>
        </li>
      `).join('');
		}
		if (industryDescriptionText) {
			industryDescriptionText.textContent = data.description;
		}
		if (industryDescriptionList) {
			industryDescriptionList.innerHTML = data.items.map(item => `
        <li>${item}</li>
      `).join('');
		}
	}

	if (industryFilterBtns.length > 0) {
		industryFilterBtns.forEach(btn => {
			btn.addEventListener('click', function () {
				// Remove active class from all buttons
				industryFilterBtns.forEach(b => b.classList.remove('active'));

				// Add active class to clicked button
				this.classList.add('active');

				// Get industry data
				const industryType = this.getAttribute('data-industry');
				updateIndustryContent(industryType);
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

