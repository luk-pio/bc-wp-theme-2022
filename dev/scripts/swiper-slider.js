const swiper = new Swiper(
  document.getElementById("single-product-swiper-container"),
  {
    loop: true,
    zoom: true,
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
    navigation: {
      nextEl: "#single-product-swiper-button-container-right",
      prevEl: "#single-product-swiper-button-container-left",
    },
    grabCursor: false,
    slidesPerView: 1,
    spaceBetween: 0,
  }
);

const rightButton = document.getElementById(
  "single-product-swiper-button-container-right"
);
const leftButton = document.getElementById(
  "single-product-swiper-button-container-left"
);
