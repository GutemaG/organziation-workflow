<template>
    <div>
        <b-row>
            <b-col>
                <b-container fluid>
                    <div class="mb-3">
                  
                        <b-carousel
                            id="carousel-fade"
                            style="text-shadow: 0px 0px 2px #000"
                            fade
                            indicators
                            img-width="1024"
                            img-height="480"
                        >
                            <b-carousel-slide
                            caption="First slide"
                            img-src="/images/astu gate.jpg"
                            ></b-carousel-slide>
                            <b-carousel-slide
                            caption="Second Slide"
                            img-src="/images/astu gate.jpg"
                            ></b-carousel-slide>
                            <b-carousel-slide
                            caption="Third Slide"
                            img-src="/images/astu gate.jpg"
                            ></b-carousel-slide>
                        </b-carousel>
                    </div>

                    <div class="mt-5 mb-5">
                        <h3>
                            Office of Academic Affairs
                        </h3>
                        <p>

                            Adama Science and Technology University, ASTU, is one of the two science and technology universities established to
                            support the industrial development of the nation by producing competent and leading graduates in science and technology fields.
                            The university is working aggressively to produce qualified, competent, and socially responsible professionals in the fields of science and
                            technology through promoting research oriented science and technology education. The academic wing has taken the leading role to ensure
                            quality education which helps to realize the goals and ultimately the mission of ASTU.  The academic affairs office was established under
                            the Vice President for Academic Affairs (VPA) to lead all academic and academic-related matters of the university.
                            Adama Science And Technology University Guidance System website
                            will help guide you through with any affairs you have with our
                            campus. To get any information related to your affair go click
                            the info button and search any kind of affair you have. But if
                            you want get your affair done online go and click the online
                            button below.
                        </p>

                        <p>
                            Adama Science and Technology University has signed a consultant
                            contract agreement with Seoul National University. Accordingly, the consultant, Seoul National University, is
                            expected to facilitate the design, supervision, and bid document preparation of the ASTU-EDCF project.
                            It is recalled that the government of South Korea has agreed to finance the establishment of five Centers of Excellence in
                            ASTU with an outlay of one hundred million US Dollars. The agreement was signed between the governments of FDRE the Republic of Korea.
                            T June 24, 2021
                        </p>

                    </div>
                </b-container>
            </b-col>
            
        </b-row>
      </div>
</template>

<script>
export default {
    data() {
      return {
        slide: 0,
        sliding: null,
        affairs:[]
      }
    },
    computed:{
      first() {
        return this.affairs[0];
      },
    },
    methods: {
      onSlideStart(slide) {
        this.sliding = true
      },
      onSlideEnd(slide) {
        this.sliding = false
      },
      getAffairs(){
        console.log('created')
      }
    },
    created() {
      // this.fetchAffairs()
      // this.$store.dispatch('fetchAffairs')
      this.getAffairs();
    },
};
</script>

<style scoped>
.contain {
  max-width: 960px;
  width: 100%;
  padding-right: 15px;
  padding-left: 15px;
  margin-right: auto;
  margin-left: auto;
  box-sizing: border-box;
}

.bLink i{
    color: rgb(255, 255, 255);
}
</style>
