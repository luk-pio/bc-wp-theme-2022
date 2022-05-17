const swiper = new Swiper(
  document.getElementById("homepage-swiper-container"),
  {
    loop: true,
    slidesPerView: 1,
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
    grabCursor: false,
    spaceBetween: 0,
    breakpoints: {},
    breakpoints: {
      840: {
        slidesPerView: 2,
      },
    },
  }
);
