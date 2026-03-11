// SELECT ALL DROPDOWNS
const dropdowns = document.querySelectorAll(".dropdown");

dropdowns.forEach(dropdown => {
    const toggle = dropdown.querySelector(".dropdown-toggle");
    const submenu = dropdown.querySelector(".sub-menu");

    // --- DESKTOP HOVER ---
    dropdown.addEventListener("mouseenter", () => {
        if (window.innerWidth > 768) { // desktop only
            if (submenu) {
                submenu.classList.add("show");
                dropdown.classList.add("open");
            }
        }
    });
    dropdown.addEventListener("mouseleave", () => {
        if (window.innerWidth > 768) {
            if (submenu) {
                submenu.classList.remove("show");
                dropdown.classList.remove("open");
            }
        }
    });

    // --- MOBILE CLICK ---
    toggle.addEventListener("click", e => {
        if (window.innerWidth <= 768) { // mobile only
            if (submenu) {
                const isOpen = submenu.classList.contains("show");

                // Ensure sidebar is expanded
                const nav = document.getElementById("nav-bar");
                if (nav.classList.contains("collapsed")) {
                    nav.classList.remove("collapsed");
                }

                if (!isOpen) {
                    // First click: open submenu, prevent link
                    e.preventDefault();
                    
                    submenu.classList.add("show");
                    dropdown.classList.add("open");

                    // Close other dropdowns
                    dropdowns.forEach(item => {
                        if (item !== dropdown) {
                            item.classList.remove("open");
                            const sub = item.querySelector(".sub-menu");
                            if (sub) sub.classList.remove("show");
                        }
                    });
                }
            }
        }
    });
});

// CLICK OUTSIDE TO CLOSE DROPDOWNS / SIDEBAR
document.addEventListener("click", (e) => {
    const nav = document.getElementById("nav-bar");
    const clickedInsideNav = nav.contains(e.target);

    if (!clickedInsideNav) {

        // Close all dropdowns
        document.querySelectorAll(".dropdown").forEach(dropdown => {
            dropdown.classList.remove("open");
            const submenu = dropdown.querySelector(".sub-menu");
            if (submenu) submenu.classList.remove("show");
        });

        // Collapse sidebar on mobile
        if (window.innerWidth <= 768) {
            nav.classList.add("collapsed");
        }
    }
});

// SIDEBAR TOGGLE
function toggleSidebar() {
    const nav = document.getElementById("nav-bar");
    nav.classList.toggle("collapsed");

    // Close all dropdowns when sidebar collapses
    if (nav.classList.contains("collapsed")) {
        document.querySelectorAll(".dropdown").forEach(dropdown => {
            dropdown.classList.remove("open");
            const submenu = dropdown.querySelector(".sub-menu");
            if (submenu) submenu.classList.remove("show");
        });
    }
}
// SEARCH FILTER
const searchInput = document.getElementById("searchInput");

if (searchInput) {
    searchInput.addEventListener("keyup", function () {
        let filter = this.value.toLowerCase();
        let cards = document.querySelectorAll(".forum-card");

        cards.forEach(card => {
            let text = card.textContent.toLowerCase();
            card.style.display = text.includes(filter) ? "block" : "none";
        });
    });
}

function openTab(tabName) {
    const contents = document.querySelectorAll(".tab-content");
    const buttons = document.querySelectorAll(".tab-btn");

    contents.forEach(c => c.classList.remove("active"));
    buttons.forEach(b => b.classList.remove("active"));

    document.getElementById(tabName).classList.add("active");
    event.target.classList.add("active");
}

//Category Filter
document.addEventListener("DOMContentLoaded", function(){

const categoryFilter = document.getElementById("categoryFilter");
const forumCards = document.querySelectorAll(".forum-card");

categoryFilter.addEventListener("change", function () {
    const selectedCategory = this.value;

    forumCards.forEach(card => {
        const cardCategory = card.getAttribute("data-category");

        if (selectedCategory === "all" || cardCategory === selectedCategory) {
            card.style.display = "block";
        } else {
            card.style.display = "none";
        }
    });
});

});