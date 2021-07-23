<template>
    <div>
        <!-- <b-container >
            <b-carousel
                class="carousel-center"
                id="carousel-fade"
                style="text-shadow: 0px 0px 2px #000;"
                fade
                indicators
                img-width="1024"
                img-height="180"
                img-fluid
                text-tag="aasdkfjaldsfjlaskjd"
                controls
            >
                <b-carousel-slide
                    caption="Adama Science And Technology University Guidance System"
                    img-src="/images/campus/astu campu1.jpg"
                    img-height="150"
                ></b-carousel-slide>
                <b-carousel-slide
                    caption="Adama Science And Technology University Guidance System"
                    img-src="/images/campus/astu campu2.jpg"
                ></b-carousel-slide>
                <b-carousel-slide
                    caption="Adama Science And Technology University Guidance System"
                    img-src="/images/campus/astu campu3.jpg"
                ></b-carousel-slide>
            </b-carousel>
        </b-container> -->

        <b-container class="mt-5">
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
                    <b-col lg="5" class="pb-4"
                        ><router-link
                            to="/hello-world"
                            class="btn btn-outline-info"
                            >Info</router-link
                        ></b-col
                    >
                    <b-col lg="5" class="pb-4"
                        ><router-link
                            to="/hello-world"
                            class="btn btn-outline-primary"
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
        <div style="left: 0; right: 0;">
            <!-- Footer -->
            <div
                class="page-footer font-small pt-0"
            >
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
                                class="text-center text-md-right"
                            >
                                <b-link class="fb-ic ml-0" style="color: white;"
                                    ><i
                                        class="fab fa-facebook white-text mr-lg-4"
                                    >
                                    </i
                                ></b-link>
                                <b-link class="tw-ic" style="color: white;"
                                    ><i
                                        class="fab fa-twitter white-text mr-lg-4"
                                    >
                                    </i
                                ></b-link>
                                <b-link class="gplus-ic" style="color: white;"
                                    ><i
                                        class="fab fa-google-plus white-text mr-lg-4"
                                    >
                                    </i
                                ></b-link>
                                <b-link class="li-ic" style="color: white;"
                                    ><i
                                        class="fab fa-linkedin-in white-text mr-lg-4"
                                    >
                                    </i
                                ></b-link>
                                <b-link class="ins-ic" style="color: white;"
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
                            <b-col md="3" lg="4" xl="3" class="mb-4">
                                <h6 class="text-uppercase font-weight-bold">
                                    <strong>Company name</strong>
                                </h6>
                                <hr
                                    class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto"
                                    style="width: 60px"
                                />
                                <p>
                                    Here you can use rows and columns here to
                                    organize your footer content. Lorem ipsum dolor
                                    sit amet, consectetur adipisicing elit.
                                </p>
                            </b-col>
                            <b-col md="2" lg="2" xl="2" class="mb-4">
                                <h6 class="text-uppercase font-weight-bold">
                                    <strong>Products</strong>
                                </h6>
                                <hr
                                    class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto"
                                    style="width: 60px"
                                />
                                <p><b-link href="#!">bootstrap</b-link></p>
                                <p><b-link href="#!">MDWordPress</b-link></p>
                                <p><b-link href="#!">BrandFlow</b-link></p>
                                <p><b-link href="#!">Bootstrap Angular</b-link></p>
                            </b-col>
                            <b-col md="3" lg="2" xl="2" class="mb-4">
                                <h6 class="text-uppercase font-weight-bold">
                                    <strong>Useful links</strong>
                                </h6>
                                <hr
                                    class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto"
                                    style="width: 60px"
                                />
                                <p><b-link href="#!">Your Account</b-link></p>
                                <p><b-link href="#!">Become an Affiliate</b-link></p>
                                <p><b-link href="#!">Shipping Rates</b-link></p>
                                <p><b-link href="#!">Help</b-link></p>
                            </b-col>
                            <b-col md="4" lg="3" xl="3" class="mb-0">
                                <h6 class="text-uppercase font-weight-bold">
                                    <strong>Contact</strong>
                                </h6>
                                <hr
                                    class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto"
                                    style="width: 60px"
                                />
                                <p>
                                    <i class="fas fa-home mr-3"></i> New York, NY
                                    10012, US
                                </p>
                                <p>
                                    <i class="fas fa-envelope mr-3"></i>
                                    info@example.com
                                </p>
                                <p>
                                    <i class="fas fa-phone mr-3"></i> + 01 234 567
                                    88
                                </p>
                                <p>
                                    <i class="fas fa-print mr-3"></i> + 01 234 567
                                    89
                                </p>
                            </b-col>
                        </b-row>
                    </b-container>
                </div>
                <div class="footer-copyright text-center py-3 pt-2 pb-2" style="background-color: #161c27; color: white;">
                    <b-container fluid>
                        &copy; 2021 Copyright
                    </b-container>
                </div>
            </div>
            <!-- Footer -->
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {};
    }
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
b-link{

}
</style>
