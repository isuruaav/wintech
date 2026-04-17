// ===== PRELOADER =====
window.addEventListener('load', () => {
    const pre = document.getElementById('preloader');
    if (pre) { pre.classList.add('hide'); setTimeout(() => pre.remove(), 600); }
});

// ===== NAVBAR SCROLL =====
const navbar = document.getElementById('navbar');
if (navbar) {
    window.addEventListener('scroll', () => {
        navbar.classList.toggle('scrolled', window.scrollY > 20);
    });
}

// ===== MOBILE MENU =====
const menuBtn = document.getElementById('menu-btn');
const mobileMenu = document.getElementById('mobile-menu');
if (menuBtn && mobileMenu) {
    menuBtn.addEventListener('click', () => {
        mobileMenu.classList.toggle('open');
        const icon = menuBtn.querySelector('i');
        icon.classList.toggle('fa-bars');
        icon.classList.toggle('fa-xmark');
    });
}

// ===== ACTIVE NAV LINK =====
document.querySelectorAll('.nav-link').forEach(link => {
    if (link.href === window.location.href) link.classList.add('active');
});

// ===== SEARCH PANEL =====
const searchBtn  = document.getElementById('search-btn');
const searchClose= document.getElementById('search-close');
const searchPanel= document.getElementById('search-panel');
if (searchBtn && searchPanel) {
    searchBtn.addEventListener('click', () => {
        searchPanel.classList.remove('hidden');
        searchPanel.querySelector('input')?.focus();
    });
}
if (searchClose && searchPanel) {
    searchClose.addEventListener('click', () => searchPanel.classList.add('hidden'));
}

// ===== SCROLL REVEAL =====
const revealObserver = new IntersectionObserver((entries) => {
    entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); revealObserver.unobserve(e.target); } });
}, { threshold: 0.12 });
document.querySelectorAll('.reveal').forEach(el => revealObserver.observe(el));

// ===== COUNTER ANIMATION =====
const counterObserver = new IntersectionObserver((entries) => {
    entries.forEach(e => {
        if (!e.isIntersecting) return;
        const el = e.target;
        const target = parseInt(el.dataset.target);
        const duration = 1800;
        const step = target / (duration / 16);
        let current = 0;
        const timer = setInterval(() => {
            current += step;
            if (current >= target) { current = target; clearInterval(timer); }
            el.textContent = Math.floor(current).toLocaleString() + (el.dataset.suffix || '');
        }, 16);
        counterObserver.unobserve(el);
    });
}, { threshold: 0.5 });
document.querySelectorAll('[data-target]').forEach(el => counterObserver.observe(el));

// ===== GALLERY LIGHTBOX =====
const lightbox  = document.getElementById('lightbox');
const lbImg     = document.getElementById('lb-img');
const lbClose   = document.getElementById('lb-close');
const lbPrev    = document.getElementById('lb-prev');
const lbNext    = document.getElementById('lb-next');
let galleryItems = [], lbIndex = 0;

document.querySelectorAll('.gallery-item[data-src]').forEach((item, i) => {
    galleryItems.push(item.dataset.src);
    item.addEventListener('click', () => openLightbox(i));
});

function openLightbox(i) {
    if (!lightbox || !lbImg) return;
    lbIndex = i; lbImg.src = galleryItems[i];
    lightbox.classList.add('active');
    document.body.style.overflow = 'hidden';
}
function closeLightbox() {
    if (!lightbox) return;
    lightbox.classList.remove('active');
    document.body.style.overflow = '';
}
if (lbClose) lbClose.addEventListener('click', closeLightbox);
if (lightbox) lightbox.addEventListener('click', e => { if (e.target === lightbox) closeLightbox(); });
if (lbPrev) lbPrev.addEventListener('click', () => openLightbox((lbIndex - 1 + galleryItems.length) % galleryItems.length));
if (lbNext) lbNext.addEventListener('click', () => openLightbox((lbIndex + 1) % galleryItems.length));
document.addEventListener('keydown', e => {
    if (!lightbox?.classList.contains('active')) return;
    if (e.key === 'Escape') closeLightbox();
    if (e.key === 'ArrowLeft') openLightbox((lbIndex - 1 + galleryItems.length) % galleryItems.length);
    if (e.key === 'ArrowRight') openLightbox((lbIndex + 1) % galleryItems.length);
});

// ===== FLASH MESSAGE AUTO DISMISS =====
document.querySelectorAll('.flash-msg').forEach(el => {
    setTimeout(() => { el.style.opacity = '0'; setTimeout(() => el.remove(), 400); }, 4000);
});

// ===== ADMIN SIDEBAR MOBILE =====
const sidebarToggle  = document.getElementById('sidebar-toggle');
const sidebar        = document.getElementById('sidebar');
const sidebarOverlay = document.getElementById('sidebar-overlay');
if (sidebarToggle && sidebar) {
    sidebarToggle.addEventListener('click', () => {
        sidebar.classList.toggle('-translate-x-full');
        sidebarOverlay?.classList.toggle('hidden');
    });
}
if (sidebarOverlay && sidebar) {
    sidebarOverlay.addEventListener('click', () => {
        sidebar.classList.add('-translate-x-full');
        sidebarOverlay.classList.add('hidden');
    });
}

// ===== IMAGE PREVIEW =====
document.querySelectorAll('input[type="file"][data-preview]').forEach(input => {
    input.addEventListener('change', () => {
        const preview = document.getElementById(input.dataset.preview);
        if (!preview || !input.files[0]) return;
        preview.src = URL.createObjectURL(input.files[0]);
        preview.classList.remove('hidden');
    });
});

// ===== CONFIRM DELETE =====
document.querySelectorAll('[data-confirm]').forEach(btn => {
    btn.addEventListener('click', e => {
        if (!confirm(btn.dataset.confirm || 'Are you sure?')) e.preventDefault();
    });
});

// ===== TABS =====
// ── Tabs Component ─────────────────────────────────────────
    document.querySelectorAll('[data-tab-group]').forEach(group => {
        const tabs   = group.querySelectorAll('[data-tab]');
        const panels = group.querySelectorAll('[data-tab-panel]');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                const target = tab.getAttribute('data-tab');

                // Reset all tabs
                tabs.forEach(t => {
                    t.classList.remove('bg-navy-900', 'text-white', 'border-navy-900');
                    t.classList.add('bg-white', 'text-slate-600', 'border-slate-200');
                });

                // Activate clicked tab
                tab.classList.add('bg-navy-900', 'text-white', 'border-navy-900');
                tab.classList.remove('bg-white', 'text-slate-600', 'border-slate-200');

                // Show matching panel
                panels.forEach(p => p.classList.add('hidden'));
                const panel = group.querySelector(`[data-tab-panel="${target}"]`);
                if (panel) panel.classList.remove('hidden');
            });
        });
    });