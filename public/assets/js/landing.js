/**
 * Landing Page Scripts
 */

// Scroll carousel helper
function scrollCarousel(id, amount) {
    const el = document.getElementById(id);
    if (el) {
        el.scrollBy({ left: amount, behavior: 'smooth' });
    }
}

// Date picker — open calendar when clicking anywhere on the date search field
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.search-date-input').forEach(function (input) {
        // Click on parent search-field should also open the picker
        var field = input.closest('.search-field');
        if (field) {
            field.style.cursor = 'pointer';
            field.addEventListener('click', function (e) {
                if (e.target !== input) {
                    if (typeof input.showPicker === 'function') {
                        input.showPicker();
                    } else {
                        input.focus();
                        input.click();
                    }
                }
            });
        }
    });
});

// Continent tabs toggle
document.addEventListener('DOMContentLoaded', function () {
    const continentTabs = document.querySelectorAll('.continent-tab');
    continentTabs.forEach(function (tab) {
        tab.addEventListener('click', function () {
            continentTabs.forEach(function (t) { t.classList.remove('active'); });
            this.classList.add('active');
        });
    });
});
