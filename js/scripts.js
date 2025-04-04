document.addEventListener('DOMContentLoaded', () => {
    const slides = document.querySelectorAll('.featured-post');
    const paginationDots = document.querySelectorAll('.pagination-dot');
    let currentSlide = 0;
    const showSlide = (index) => {
        slides.forEach((slide, i) => {
            slide.classList.remove('active');
            paginationDots[i].classList.remove('active');
        });
        slides[index].classList.add('active');
        paginationDots[index].classList.add('active');
    };
    const nextSlide = () => {
        currentSlide = (currentSlide + 1) % slides.length;
        showSlide(currentSlide);
    };
    if (slides.length > 0) {
        const slideInterval = setInterval(nextSlide, 15000);
        paginationDots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                clearInterval(slideInterval);
                currentSlide = index;
                showSlide(currentSlide);
            });
        });
        showSlide(currentSlide);
    }
    const loadMoreButton = document.getElementById('load-more-posts');
    const postsContainer = document.getElementById('latest-posts-container');
    if (loadMoreButton) {
        let offset = parseInt(loadMoreButton.getAttribute('data-offset'));
        loadMoreButton.addEventListener('click', () => {
            fetch(ajax_params.ajax_url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    action: 'load_more_posts',
                    offset: offset,
                    nonce: ajax_params.nonce,
                }),
            })
                .then((response) => response.text())
                .then((data) => {
                    if (data && data.trim() !== '') {
                        postsContainer.insertAdjacentHTML('beforeend', data);
                        offset += 3;
                        loadMoreButton.setAttribute('data-offset', offset);
                        loadMoreButton.textContent = 'Daha Fazla Yükle';
                    } else {
                        loadMoreButton.textContent = 'Daha Fazla Gönderi Yok';
                        loadMoreButton.disabled = true;
                    }
                })
                .catch(() => {
                    loadMoreButton.textContent = 'Hata Oluştu';
                });
            loadMoreButton.textContent = 'Yükleniyor...';
        });
    }
    const darkModeToggle = document.querySelector('.dark-mode-toggle');
    const body = document.body;
    if (darkModeToggle) {
        darkModeToggle.addEventListener('click', () => {
            darkModeToggle.classList.toggle('active');
            body.classList.toggle('dark-mode');
            if (body.classList.contains('dark-mode')) {
                localStorage.setItem('darkModeButtonState', 'active');
            } else {
                localStorage.setItem('darkModeButtonState', 'inactive');
            }
        });
        const savedButtonState = localStorage.getItem('darkModeButtonState');
        if (savedButtonState === 'active') {
            darkModeToggle.classList.add('active');
            body.classList.add('dark-mode');
        } else if (savedButtonState === 'inactive') {
            darkModeToggle.classList.remove('active');
            body.classList.remove('dark-mode');
        } else {
            if (dark_theme_settings.default_mode === 'dark') {
                darkModeToggle.classList.add('active');
                body.classList.add('dark-mode');
            } else {
                darkModeToggle.classList.remove('active');
                body.classList.remove('dark-mode');
            }
        }
    } else {
        if (dark_theme_settings.default_mode === 'dark') {
            body.classList.add('dark-mode');
        } else {
            body.classList.remove('dark-mode');
        }
    }
});

jQuery(document).ready(function($) {
    $('.menu-toggle').click(function() {
        $(this).toggleClass('active');
        $('.nav-menu').toggleClass('active');
        const expanded = $(this).attr('aria-expanded') === 'true' ? 'false' : 'true';
        $(this).attr('aria-expanded', expanded);
    });
    $('.nav-menu .menu-item-has-children > a').click(function(e) {
        if ($(window).width() <= 768 && $(this).siblings('.sub-menu').length > 0) {
            e.preventDefault();
            $(this).parent('li').toggleClass('active');
        }
    });
});