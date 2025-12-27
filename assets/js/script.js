// Mobile Menu Toggle
const mobileMenuToggle = document.getElementById('mobileMenuToggle');
const navMenu = document.getElementById('navMenu');

if (mobileMenuToggle) {
    mobileMenuToggle.addEventListener('click', () => {
        navMenu.classList.toggle('active');
    });
}

// Subscribe Modal
const subscribeBtn = document.querySelector('.subscribe-btn');
const subscribeModal = document.getElementById('subscribeModal');
const closeModal = document.querySelector('.close-modal');

if (subscribeBtn) {
    subscribeBtn.addEventListener('click', () => {
        subscribeModal.style.display = 'block';
    });
}

if (closeModal) {
    closeModal.addEventListener('click', () => {
        subscribeModal.style.display = 'none';
    });
}

window.addEventListener('click', (e) => {
    if (e.target === subscribeModal) {
        subscribeModal.style.display = 'none';
    }
});

// Subscribe Form Handler
const subscribeForm = document.getElementById('subscribeForm');
if (subscribeForm) {
    subscribeForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(subscribeForm);
        
        try {
            const response = await fetch('subscribe.php', {
                method: 'POST',
                body: formData
            });
            
            const result = await response.json();
            const messageDiv = document.getElementById('subscribeMessage');
            
            if (result.success) {
                messageDiv.innerHTML = '<p style="color: green;">' + result.message + '</p>';
                subscribeForm.reset();
                setTimeout(() => {
                    subscribeModal.style.display = 'none';
                    messageDiv.innerHTML = '';
                }, 2000);
            } else {
                messageDiv.innerHTML = '<p style="color: red;">' + result.message + '</p>';
            }
        } catch (error) {
            console.error('Error:', error);
        }
    });
}

// Newsletter Form Handler
const newsletterForm = document.getElementById('newsletterForm');
if (newsletterForm) {
    newsletterForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(newsletterForm);
        
        try {
            const response = await fetch('subscribe.php', {
                method: 'POST',
                body: formData
            });
            
            const result = await response.json();
            const messageDiv = document.getElementById('newsletterMessage');
            
            if (result.success) {
                messageDiv.innerHTML = '<p style="color: #4CAF50; margin-top: 1rem;">' + result.message + '</p>';
                newsletterForm.reset();
            } else {
                messageDiv.innerHTML = '<p style="color: #f44336; margin-top: 1rem;">' + result.message + '</p>';
            }
        } catch (error) {
            console.error('Error:', error);
        }
    });
}

// Contact Form Handler
const contactForm = document.getElementById('contactForm');
if (contactForm) {
    contactForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(contactForm);
        
        try {
            const response = await fetch('contact-submit.php', {
                method: 'POST',
                body: formData
            });
            
            const result = await response.json();
            const messageDiv = document.getElementById('contactMessage');
            
            if (result.success) {
                messageDiv.innerHTML = '<p style="color: green; margin-top: 1rem;">' + result.message + '</p>';
                contactForm.reset();
            } else {
                messageDiv.innerHTML = '<p style="color: red; margin-top: 1rem;">' + result.message + '</p>';
            }
        } catch (error) {
            console.error('Error:', error);
        }
    });
}

// Scroll to Top Button
const scrollTopBtn = document.getElementById('scrollTop');

window.addEventListener('scroll', () => {
    if (window.pageYOffset > 300) {
        scrollTopBtn.style.display = 'flex';
    } else {
        scrollTopBtn.style.display = 'none';
    }
});

if (scrollTopBtn) {
    scrollTopBtn.addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
}

// Smooth Scroll for Internal Links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        const href = this.getAttribute('href');
        if (href !== '#') {
            e.preventDefault();
            const target = document.querySelector(href);
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        }
    });
});

// Animation on Scroll
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
        }
    });
}, observerOptions);

document.querySelectorAll('.blog-card, .featured-card, .category-card').forEach(el => {
    el.style.opacity = '0';
    el.style.transform = 'translateY(20px)';
    el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
    observer.observe(el);
});

// Ad Popup Modal (Homepage only - Side Popup)
// Shows every time the page reloads
function initAdPopup() {
    const adPopupModal = document.getElementById('adPopupModal');
    const adCloseBtn = document.querySelector('.ad-close-btn');
    
    // Only run if ad popup exists (homepage only - since it's only in index.php)
    if (adPopupModal) {
        // Show ad popup every time page loads (after a short delay for better UX)
        setTimeout(() => {
            if (adPopupModal) {
                adPopupModal.style.display = 'block';
                // Small delay to trigger animation
                setTimeout(() => {
                    adPopupModal.classList.add('show');
                }, 10);
            }
        }, 2000);
        
        // Close ad popup when X button is clicked
        if (adCloseBtn) {
            adCloseBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                if (adPopupModal) {
                    adPopupModal.classList.remove('show');
                    // Wait for animation, then hide
                    setTimeout(() => {
                        adPopupModal.style.display = 'none';
                    }, 500);
                }
            });
        }
    }
}

// Run when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initAdPopup);
} else {
    // DOM is already ready
    initAdPopup();
}