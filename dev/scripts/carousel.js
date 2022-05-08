document.addEventListener("alpine:init", () => {
  Alpine.data("carousel", () => ({
    active: 0,
    init() {
      var flkty = new Flickity(this.$refs.carousel, {
        wrapAround: true,
      });
      flkty.on("change", (i) => (this.active = i));
    },
  }));
  Alpine.data("carouselFilter", () => ({
    active: 0,
    changeActive(i) {
      this.active = i;

      this.$nextTick(() => {
        let flkty = Flickity.data(this.$el.querySelectorAll(".carousel")[i]);
        flkty.resize();

        console.log(flkty);
      });
    },
  }));
});

function carousel() {
  return {
    active: 0,
    init() {
      var flkty = new Flickity(this.$refs.carousel, {
        wrapAround: true,
      });
      flkty.on("change", (i) => (this.active = i));
    },
  };
}

// function carouselFilter() {
//   return {
//     active: 0,
//     changeActive(i) {
//       this.active = i;

//       this.$nextTick(() => {
//         let flkty = Flickity.data(this.$el.querySelectorAll(".carousel")[i]);
//         flkty.resize();

//         console.log(flkty);
//       });
//     },
//   };
// }
