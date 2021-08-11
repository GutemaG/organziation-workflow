<template>
    <div>
        <b-container fluid>
            <b-row>
                <b-col>
                    <b-container class="mt-3">
                        <div class="mb-3">
                            <div style="z-index: 111; position: absolute; text-align: center; margin-bottom: 2rem;
                            top: 150px;
                            width: 80%;
                            background-color: #00000042;
                            color: white;">
                                <h2>Adama Science And Technology University</h2>
                                <h2>Guidance System</h2>
                            </div>
                            
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
                                img-src="https://picsum.photos/1024/480/?image=10"
                                ></b-carousel-slide>
                                <b-carousel-slide
                                caption="Second Slide"
                                img-src="https://picsum.photos/1024/480/?image=12"
                                ></b-carousel-slide>
                                <b-carousel-slide
                                caption="Third Slide"
                                img-src="https://picsum.photos/1024/480/?image=22"
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
                            
                            <b-row>
                                <div style="display: flex;
                                position: relative;
                                margin: 2rem auto;"
                                >
                                    <b-col lg="5"
                                        ><router-link rounded="2"
                                            to="/info"
                                            class="btn btn-info btn-lg p-2"
                                            >Info</router-link
                                        ></b-col
                                    >
                                    <b-col lg="5"
                                        ><router-link
                                            to="/online"
                                            class="btn btn-primary btn-lg p-2"
                                            >Online</router-link
                                        ></b-col
                                    >
                                </div>
                            </b-row>

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
                        <b-card bg-variant="dark" header="Dark" text-variant="white" class="text-center">
                            <b-card-text class="text-left">Lorem ipsum dolor sit amet, consectetur adipiscing elit alekj aoiejf lasdjfoew adsfj ewo.</b-card-text>
                        </b-card>
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
            </div>
        </div>
        <!-- Footer -->
        <div
          class="footer-copyright text-center py-3 pt-2 pb-2"
          style="background-color: #161c27; color: white">
          <b-container fluid> &copy; 2021 Copyright </b-container>
        </div>
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
