const appBase = "http://localhost/food-os";
const appDashboard = "http://localhost/food-os/dashboard";

(() => {
  const navLink = document.querySelectorAll(".nav-link");
  const date = document.getElementById("date");
  navLink.forEach((link) => {
    // var wHash = location.href + "#";
    // console.log(location.href.match(new RegExp(link.href + "(.*)?")));
    // const matches = location.href.match(new RegExp(link.href + "(.*)?"));

    const drop = () => {
      const root = location.href.split("?")[0];
      if (link.id !== "") {
        return root.endsWith(link.id + ".php");
      }
    };

    if (link.href === location.href || drop()) {
      if (link.classList.contains("nav-link")) link.classList += " text-red";
      else link.classList += " active text-red";
    }
  });
  date.innerHTML = new Date().getFullYear();
})();

// show hide header
const body = document.querySelector("body");
const header = document.querySelector("header");
const navbar = document.querySelector(".navbar");

const scrollUp = "scroll-up";
const scrollDown = "scroll-down";
let lastScroll = 0;

window.addEventListener("scroll", () => {
  const currentScroll = window.pageYOffset;

  if (currentScroll <= 0) {
    body.classList.remove(scrollUp);
    return;
  }

  if (currentScroll > lastScroll && !body.classList.contains(scrollDown)) {
    // down
    body.classList.remove(scrollUp);
    body.classList.add(scrollDown);
  } else if (
    currentScroll < lastScroll &&
    body.classList.contains(scrollDown)
  ) {
    // up
    body.classList.remove(scrollDown);
    body.classList.add(scrollUp);
  }

  currentScroll >= 50
    ? header.classList.add("shadow-sm")
    : header.classList.remove("shadow-sm");

  lastScroll = currentScroll;
});

// sidebar
const sideBar = document.getElementById("sidebar");
const sideBarToggler = document.getElementById("sidebar-toggler");
const sideBarNavText = document.querySelectorAll(".sidebar-nav-text");
const sideBarCol = document.getElementById("sidebar-col");
const sideBarDrop = document.querySelectorAll(".sidebar-drop");
const sideBarDrops = document.querySelectorAll(".sidebar-drops");
const sideBarDropper = document.querySelectorAll(".sidebar-dropper");
// sidebar-drop
if (sideBarToggler) {
  sideBarToggler.addEventListener("click", () => {
    sideBarCol.classList.toggle("sidebar-grow");
    sideBarCol.classList.toggle("sidebar-shrink");

    sideBarCol.firstElementChild.classList.toggle("sidebar-grow");
    sideBarCol.firstElementChild.classList.toggle("sidebar-shrink");

    sideBar.classList.toggle("sidebar-grow");
    sideBar.classList.toggle("sidebar-shrink");

    sideBarDrop.forEach((drop) => {
      drop.classList.toggle("dropright");
    });
    sideBarDrops.forEach((drop) => {
      drop.classList.toggle("collapse");
      drop.classList.toggle("dropdown-menu");
      drop.classList.toggle("shadow-sm");
      drop.classList.toggle("border-bottom");
      drop.classList.toggle("border-none");
    });
    sideBarDropper.forEach((drop) => {
      if (sideBar.classList.contains("sidebar-grow")) {
        drop.setAttribute("data-toggle", "collapse");
        drop.href = "#" + drop.id + "-drop";
      } else {
        drop.setAttribute("data-toggle", "dropdown");
        drop.removeAttribute("href");
      }
    });

    sideBarNavText.forEach((text) => {
      text.classList.toggle("d-none");
    });

    sideBar.classList.contains("sidebar-grow")
      ? (sideBarToggler.innerHTML = `<i class="fa fa-chevron-left"></i>`)
      : (sideBarToggler.innerHTML = `<i class="fa fa-chevron-right"></i>`);
  });
}

// redirecting
const redirect = (path = "/", int = true) => {
  console.log(path);
  return int === true
    ? (window.location.href = appBase + path)
    : (window.location.href = path);
};

// slide index
const cardCarousels = document.querySelectorAll(".cardCarousel");
let isDown = false;
let startX;
let scrollLeft;
cardCarousels.forEach((cardCarousel) => {
  cardCarousel.addEventListener("mousedown", (e) => {
    isDown = true;
    startX = e.pageX - cardCarousel.scrollLeft;
    scrollLeft = cardCarousel.scrollLeft;
  });
  cardCarousel.addEventListener("mouseleave", () => {
    isDown = false;
  });
  cardCarousel.addEventListener("mouseup", () => {
    isDown = false;
  });
  cardCarousel.addEventListener("mousemove", (e) => {
    if (!isDown) return;
    e.preventDefault();
    const x = e.pageX - cardCarousel.offsetLeft;
    const walk = (x - startX) * 3;
    const walking = scrollLeft - walk;
    cardCarousel.scrollLeft = walking;
  });
});
