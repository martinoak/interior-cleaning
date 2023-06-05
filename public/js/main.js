(function () {
    "use strict";

    // ======= Sticky
    window.onscroll = function () {
        const ud_header = document.querySelector(".ud-header");
        const sticky = ud_header.offsetTop;
        const logo = document.querySelector(".navbar-brand img");
        const logoText = document.querySelector(".navbar-brand-text");
        const burger = document.querySelector(".navbar-toggler i");

        if (window.scrollY > sticky) {
            ud_header.classList.add("ud-sticky");
        } else {
            ud_header.classList.remove("ud-sticky");
        }

        // === logo change
        if (ud_header.classList.contains("ud-sticky")) {
            logo.src = "../images/logo/logo-car2.png";
            logoText.style.color = "#3056d3";
            burger.className = "fa-solid fa-bars text-primary";
        } else {
            logo.src = "../images/logo/logo-car.png";
            logoText.style.color = "#fff";
            burger.className= "fa-solid fa-bars text-white";
        }

        // show or hide the back-top-top button
        const backToTop = document.querySelector(".back-to-top");
        if (
            document.body.scrollTop > 50 ||
            document.documentElement.scrollTop > 50
        ) {
            backToTop.style.display = "flex";
        } else {
            backToTop.style.display = "none";
        }
    };

    //===== close navbar-collapse when a  clicked
    let navbarToggler = document.querySelector(".navbar-toggler");
    const navbarCollapse = document.querySelector(".navbar-collapse");

    document.querySelectorAll(".ud-menu-scroll").forEach((e) =>
        e.addEventListener("click", () => {
            navbarToggler.classList.remove("active");
            navbarCollapse.classList.remove("show");
        })
    );
    navbarToggler.addEventListener("click", function () {
        navbarToggler.classList.toggle("active");
        navbarCollapse.classList.toggle("show");
    });

    // ===== submenu
    const submenuButton = document.querySelectorAll(".nav-item-has-children");
    submenuButton.forEach((elem) => {
        elem.querySelector("a").addEventListener("click", () => {
            elem.querySelector(".ud-submenu").classList.toggle("show");
        });
    });

    // ====== scroll top js
    function scrollTo(element, to = 0, duration = 500) {
        const start = element.scrollTop;
        const change = to - start;
        const increment = 20;
        let currentTime = 0;

        const animateScroll = () => {
            currentTime += increment;

            element.scrollTop = Math.easeInOutQuad(currentTime, start, change, duration);

            if (currentTime < duration) {
                setTimeout(animateScroll, increment);
            }
        };

        animateScroll();
    }

    Math.easeInOutQuad = function (t, b, c, d) {
        t /= d / 2;
        if (t < 1) return (c / 2) * t * t + b;
        t--;
        return (-c / 2) * (t * (t - 2) - 1) + b;
    };

    document.querySelector(".back-to-top").onclick = () => {
        scrollTo(document.documentElement);
    };
})();

// ==== for menu scroll
const pageLink = document.querySelectorAll(".ud-menu-scroll");
pageLink.forEach((elem) => {
    elem.addEventListener("click", (e) => {
        e.preventDefault();
        document.querySelector(elem.getAttribute("href")).scrollIntoView({
            behavior: "smooth",
            block: "start",
        });
    });
});
// section menu active
function onScroll() {
    const sections = document.querySelectorAll(".ud-menu-scroll");
    const scrollPos =
        window.scrollY ||
        document.documentElement.scrollTop ||
        document.body.scrollTop;
    for (let i = 0; i < sections.length; i++) {
        const currLink = sections[i];
        const val = currLink.getAttribute("href");
        const refElement = document.querySelector(val);
        const scrollTopMinus = scrollPos + 73;
        if (
            refElement.offsetTop <= scrollTopMinus &&
            refElement.offsetTop + refElement.offsetHeight > scrollTopMinus
        ) {
            document
                .querySelector(".ud-menu-scroll")
                .classList.remove("active");
            currLink.classList.add("active");
        } else {
            currLink.classList.remove("active");
        }
    }
}
window.document.addEventListener("scroll", onScroll);
