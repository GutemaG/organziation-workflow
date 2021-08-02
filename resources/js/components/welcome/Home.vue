<template>
    <div>
        <b-container fluid>
            <b-row>
                <b-col>
                    <b-container class="mt-3">
                        <div>
                            <b-carousel
                            id="carousel-1"
                            v-model="slide"
                            :interval="4000"
                            controls
                            indicators
                            background="#ababab"
                            img-width="1024"
                            img-height="480"
                            style="text-shadow: 1px 1px 2px #333;"
                            @sliding-start="onSlideStart"
                            @sliding-end="onSlideEnd"
                            class="mb-3"
                            >
                                <!-- Text slides with image -->
                                <b-carousel-slide
                                    caption="First slide"
                                    text="Nulla vitae elit libero, a pharetra augue mollis interdum."
                                    img-src="https://picsum.photos/1024/480/?image=52"
                                ></b-carousel-slide>
                                <!-- Slides with custom text -->
                                <b-carousel-slide img-src="https://picsum.photos/1024/480/?image=54">
                                    <h1>Hello world!</h1>
                                </b-carousel-slide>

                                <!-- Slides with image only -->
                                <b-carousel-slide img-src="https://picsum.photos/1024/480/?image=58"></b-carousel-slide>

                                <!-- Slides with img slot -->
                                <!-- Note the classes .d-block and .img-fluid to prevent browser default image alignment -->
                                <b-carousel-slide>
                                    <template #img>
                                    <img
                                        class="d-block img-fluid w-100"
                                        width="1024"
                                        height="480"
                                        src="https://picsum.photos/1024/480/?image=55"
                                        alt="image slot"
                                    >
                                    </template>
                                </b-carousel-slide>
                            </b-carousel>
                        </div>
                        <div style="text-align: center; margin-bottom: 2rem;">
                            <h2>Adama Science And Technology University</h2>
                            <h2>Guidance System</h2>
                        </div>
                        <p>
                            Adama Science And Technology University Guidance System website
                            will help guide you through with any affairs you have with our
                            campus. To get any information related to your affair go click
                            the info button and search any kind of affair you have. But if
                            you want get your affair done online go and click the online
                            button below.
                        </p>
                        <b-row center>
                            <div
                                class="d-flex align-items-center justify-content-center"
                                style="margin-left: 380px !important;"
                            >
                                <b-col lg="5" class="pb-4 m-3"
                                    ><router-link
                                        to="/info"
                                        class="btn btn-info btn-lg"
                                        >Info</router-link
                                    ></b-col
                                >
                                <b-col lg="5" class="pb-4 m-3"
                                    ><router-link
                                        to="/online"
                                        class="btn btn-primary btn-lg"
                                        >Online</router-link
                                    ></b-col
                                >
                            </div>
                        </b-row>
                        <div class="mb-5">
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

                <b-col cols="3">
                    <b-container class="mt-3">
                        <b-breadcrumb>
                            <b-breadcrumb-item>
                                <router-link to="/"><b-icon icon="house-fill" scale="1.25" shift-v="1.25" aria-hidden="true"></b-icon>
                                Home</router-link>
                                
                            </b-breadcrumb-item>
                            <b-breadcrumb-item>
                                <router-link to="/info">Info</router-link>
                            </b-breadcrumb-item>
                            <b-breadcrumb-item to="/online">Online</b-breadcrumb-item>
                        </b-breadcrumb>
                    </b-container>
                </b-col>
            </b-row>
        </b-container>
        
        <div style="left: 0; right: 0;">
            <!-- Footer -->
            <div class="page-footer font-small pt-0">
                <div style="backgroundColor: #6351ce">
                    <b-container class="text-left">
                        <b-row class="py-4 d-flex align-items-center" style="color: white;">
                            <b-col
                                md="6"
                                lg="5"
                                class="text-center text-md-left mb-4 mb-md-0"
                            >
                                <h6 class="mb-0 white-text">
                                    Get connected with us on social networks!
                                </h6> 
                            </b-col>
                            <b-col
                                md="6"
                                lg="7"
                                class="text-center text-md-right bLink"
                                style="font-size: 1.7rem;"
                            >
                                <b-link class="fb-ic ml-0"
                                    ><i
                                        class="fab fa-facebook white-text mr-lg-4"
                                    >
                                    </i
                                ></b-link>
                                <b-link class="tw-ic"
                                    ><i 
                                        class="fab fa-twitter white-text mr-lg-4"
                                    >
                                    </i
                                ></b-link>
                                <b-link class="gplus-ic"
                                    ><i
                                        class="fab fa-google-plus white-text mr-lg-4"
                                    >
                                    </i
                                ></b-link>
                                <b-link class="li-ic"
                                    ><i
                                        class="fab fa-linkedin-in white-text mr-lg-4"
                                    >
                                    </i
                                ></b-link>
                                <b-link class="ins-ic"
                                    ><i 
                                        class="fab fa-instagram white-text mr-lg-4"
                                    >
                                    </i
                                ></b-link>
                            </b-col>
                        </b-row>
                    </b-container>
                </div>
                <div class="pt-5 pb-5 text-center text-md-left" center style="background-color: #1c2331; color: white;">
                    <b-container>

                        <b-row class="mt-0 py-3 pt-2 pb-2" style="margin: 0; left: 12rem">
                            <b-col md="3" lg="4" xl="4" class="mb-4">
                                <h1 class="text-uppercase font-weight-bold">
                                    <strong>ASTU</strong>
                                    <br>
                                    <strong>Guidance</strong>
                                </h1>
                                <p>
                                    
                                </p>
                            </b-col>

                            <b-col md="3" lg="4" xl="4" class="mb-4">
                                <h6 class="text-uppercase font-weight-bold">
                                    <strong>Help Center</strong>
                                </h6>
                                <hr
                                    class="accent-2 mb-4 mt-0 d-inline-block mx-auto"
                                    style="width: 60px; background-color: #6A5ACD;"
                                />
                                <p><b-link href="#" style="color: white; text-decoration: none;">Help</b-link></p>
                            </b-col>
                            <b-col md="4" lg="3" xl="4" class="mb-0">
                                <h6 class="text-uppercase font-weight-bold">
                                    <strong>Contact</strong>
                                </h6>
                                <hr
                                    class="accent-2 mb-4 mt-0 d-inline-block mx-auto"
                                    style="width: 60px; background-color: #6A5ACD;"
                                />
                                <p>
                                    <i class="fas fa-home mr-3"></i> Addis Abeba, Ethiopia 2013
                                </p>
                                <p>
                                    <i class="fas fa-envelope mr-3"></i>
                                    info@astu.com
                                </p>
                                <p>
                                    <i class="fas fa-phone mr-3"></i> +251911223366
                                </p>
                                <p>
                                    <i class="fas fa-print mr-3"></i> +251900000000
                                </p>
                            </b-col>
                        </b-row>
                    </b-container>
                </div>
                <div class="footer-copyright text-center py-3 pt-2 pb-2" style="background-color: #161c27; color: white;">
                    <b-container fluid>
                        &copy; 2013 Copyright
                    </b-container>
                </div>
            </div>
            <!-- Footer -->
        </div>
        <div
          class="footer-copyright text-center py-3 pt-2 pb-2"
          style="background-color: #161c27; color: white"
        >
          <b-container fluid> &copy; 2021 Copyright </b-container>
        </div>
      </div>
      <!-- Footer -->
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
