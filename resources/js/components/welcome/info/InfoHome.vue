<template>
    <b-container fluid>
        <b-row class="mt-3">
            <b-col>
                <b-container class="infoHome">
                    <h1 class="text-center">INFORMATION CENTER</h1>
                    <p>
                        Here you can access our organization's affairs that can help you with. Below you will see list of affairs and these lists of affairs have
                        thier own way of procedures that will meet your need. Go ahead and click the tabs to view thier description.
                    </p>

                    <div class="text-center">
                        <b-button href="#student" variant="secondary" class="m-4 p-2">Student</b-button>
                        <b-button href="#staff" variant="secondary" class="m-4 p-2">Staff</b-button>
                    </div>

                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Veritatis sequi minus hic, officiis optio ratione. Vel libero beatae, 
                        architecto, et aliquid labore, repudiandae minus fugiat nam aut quasi ducimus ea.
                        Beatae odio explicabo consequuntur, animi repellat, a quasi earum aliquam deserunt eos porro praesentium cumque commodi, 
                        ut omnis eligendi iste inventore nam obcaecati totam! Minima quis atque possimus quia reiciendis.
                        Dolorum non nihil quaerat dicta nobis nam obcaecati, voluptates enim excepturi praesentium fuga maiores sint a eveniet possimus 
                        eum explicabo laborum sunt quisquam porro commodi! Quo dolorum animi nostrum consectetur!
                        Expedita quasi autem rem adipisci ipsum, animi inventore ea nemo corporis corrupti sint labore sequi eaque cum accusamus! Obcaecati, odio. 
                        Harum non quo hic inventore sint quidem maiores, in expedita!
                    </p>

                    <div id="student" class="mt-3 mb-3">
                        <!-- Tabs to provide information on Students -->
                        <b-card
                        header="Student" 
                        header-bg-variant="dark"
                        header-text-variant="light"
                        header-html="<h2><strong>Student</strong></h2>"
                        text-variant="dark"
                        no-body
                        >
                            <b-tabs card fill 
                            active-nav-item-class="font-weight-bold bg-light"
                            >
                                <b-tab title="Registral">
                                    <h3>Lorem ipsum, dolor sit amet consectetur</h3>
                                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. 
                                        Numquam, culpa. Sint, a laborum quia porro molestias vero consequatur pariatur aut similique at mollitia 
                                        ratione sapiente explicabo. Ipsa voluptatem consequuntur culpa.
                                        Quae ab beatae eos cupiditate voluptatem, dolorum impedit fugiat explicabo perspiciatis autem illo 
                                        consequatur unde necessitatibus perferendis, accusamus totam dignissimos, esse ut blanditiis at libero iste! 
                                        Saepe eos voluptate voluptatibus.
                                    </p>

                                    <!-- For list of affairs -->
                                    <b-row>
                                        <b-col>
                                            <b-card-group class="mb-2 mt-2" v-for="affair in affairs" :key="affair.id">
                                                <b-card header-bg-variant="info" header-text-variant="dark">
                                                    <template #header>
                                                        <div>
                                                            <h4>{{ affair.name }}</h4>
                                                        </div>
                                                    </template>


                                                    <!-- Via array of string IDs passed to directive value -->
                                                    <div v-for="procedure in affair.procedures" :key="procedure.id">
                                                        <b-button 
                                                        block squared 
                                                        variant="outline" 
                                                        v-b-toggle.collapse-1
                                                        class="d-flex mt-2 align-items-center" style="text-align: left;">
                                                            <b-icon icon="hand-index-thumb" font-scale="2" rotate="90" class="d-flex justify-content-between align-items-center mr-2"></b-icon>
                                                            <strong>{{ procedure.name }}</strong>
                                                            <div class="h6 ml-3">
                                                                <b-badge pill variant="primary">{{ procedure.step }} steps required</b-badge>
                                                            </div>
                                                        </b-button>

                                                        <!-- Elements to collapse -->
                                                        <b-collapse id="collapse-1" class="ml-5 mr-0 mt-2 mb-2">
                                                            <b-card border-variant="">
                                                                <p>
                                                                    {{ procedure.description }}
                                                                </p>
                                                                <div v-if="procedure.pre_requests.length > 0">

                                                                </div>
                                                                <h5>The Pre-requests required are: </h5>
                                                                <b-card border-variant="info" class="ml-5 mr-0 mt-1">
                                                                    <b-list-group flush v-for="pre_request in procedure.pre_requests" :key="pre_request.id">
                                                                        <b-list-group-item button class="align-items-center" v-b-toggle="['collapse-c']">
                                                                            <b-icon icon="hand-index-thumb" font-scale="2" rotate="90" class="d-flex justify-content-between align-items-center mr-2"></b-icon>                                                            
                                                                            <strong>{{ pre_request.name }}</strong>
                                                                        </b-list-group-item>
                                                                        <!-- toggle c -->
                                                                        <b-card-group block>
                                                                            <b-collapse id="collapse-c" class="ml-5 mr-0 mt-1 mb-1">
                                                                                <b-card border-variant="info" class="">{{ pre_request.description }}</b-card>
                                                                            </b-collapse>
                                                                        </b-card-group>
                                                                    </b-list-group>
                                                                </b-card>
                                                            </b-card>
                                                        </b-collapse>
                                                    </div>
                                                </b-card>
                                            </b-card-group>
                                        </b-col>
                                    </b-row>

                                    <p>
                                        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Commodi quas ratione, ducimus nisi dolor vitae non, 
                                        fugiat aspernatur obcaecati aut laudantium architecto repudiandae nobis nesciunt alias rem beatae, et minus?
                                        Sunt placeat saepe dolores reprehenderit atque repellendus alias inventore quae. Excepturi sunt blanditiis sit obcaecati, 
                                        minima aut maxime vitae veritatis voluptate accusantium eaque ea voluptatibus nulla architecto, molestias corrupti! Totam!
                                        Voluptatem, est. Ipsam aliquid doloribus molestias ea quasi error earum deleniti ex qui rem ut quaerat quod officiis temporibus, 
                                        minus sequi ab libero recusandae natus eveniet eligendi repudiandae tenetur beatae?
                                        Iure quas pariatur rem veniam. Repellendus necessitatibus pariatur a quam excepturi, dolorem aliquam, sunt alias ducimus possimus 
                                        id architecto reiciendis. Voluptatem minima necessitatibus sit facilis optio consequatur sunt libero provident?
                                        Nesciunt, magni. Cupiditate veritatis consequuntur nulla, repudiandae perspiciatis rerum consequatur quam ipsum fuga nemo ex recusandae 
                                        facere itaque, suscipit deserunt dolore quos tenetur minus. Laborum ducimus ipsa corrupti esse porro!
                                    </p>
                                </b-tab>

                                <b-tab title="School Of Electrical And Computing Engineering">
                                    <h3>Lorem, ipsum dolor sit amet consectetur adipisicing elit.</h3>
                                    <p>
                                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Odit voluptatem culpa minima necessitatibus minus, 
                                        officia, et in ducimus cum, perferendis at. Sapiente voluptatum totam maiores provident repellat quod quasi tenetur!
                                        Quia nisi aliquid alias quam officia aspernatur id officiis? Laudantium cupiditate veritatis vero placeat saepe eius soluta explicabo. 
                                        Cum, molestiae corrupti vitae maiores magni officiis rerum possimus accusamus expedita laborum!
                                    </p>
                                    <h3>Lorem, ipsum dolor sit amet consectetur adipisicing elit.</h3>
                                    <p>
                                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Odit voluptatem culpa minima necessitatibus minus, 
                                        officia, et in ducimus cum, perferendis at. Sapiente voluptatum totam maiores provident repellat quod quasi tenetur!
                                        Quia nisi aliquid alias quam officia aspernatur id officiis? Laudantium cupiditate veritatis vero placeat saepe eius soluta explicabo. 
                                        Cum, molestiae corrupti vitae maiores magni officiis rerum possimus accusamus expedita laborum!
                                    </p>
                                </b-tab>

                                <b-tab title="School Of Mechanical And Chemical Engineering">
                                    <h2>Lorem ipsum dolor sit, amet consectetur adipisicing elit.</h2>
                                    <p>
                                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptates, repudiandae. Id autem animi nulla, recusandae nemo quos minima 
                                        voluptates impedit rerum! Veritatis ex quaerat assumenda blanditiis exercitationem, nobis maiores eius?
                                        Animi non natus facilis provident deleniti quo nostrum vero reiciendis repudiandae velit illo eligendi corporis 
                                        quibusdam ipsa dolore inventore, architecto quae! Harum a sint corrupti obcaecati possimus blanditiis nostrum ratione!
                                        Optio molestiae libero nobis corrupti et dolorem tenetur tempore sit, officia, natus repellendus voluptas fuga nostrum? Minima, fuga saepe, 
                                        commodi repellendus praesentium odio mollitia facere reprehenderit consectetur repudiandae qui magni.
                                        Eveniet itaque necessitatibus excepturi maiores cupiditate at obcaecati debitis vitae, aperiam ad aspernatur incidunt veritatis recusandae, 
                                        quisquam saepe non a aliquid minima, esse rem. Eligendi, voluptate. Quos laboriosam nostrum culpa.
                                    </p>
                                    <h2>Lorem ipsum dolor sit, amet consectetur adipisicing elit.</h2>
                                    <p>
                                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptates, repudiandae. Id autem animi nulla, recusandae nemo quos minima 
                                        voluptates impedit rerum! Veritatis ex quaerat assumenda blanditiis exercitationem, nobis maiores eius?
                                        Animi non natus facilis provident deleniti quo nostrum vero reiciendis repudiandae velit illo eligendi corporis 
                                        quibusdam ipsa dolore inventore, architecto quae! Harum a sint corrupti obcaecati possimus blanditiis nostrum ratione!
                                        Optio molestiae libero nobis corrupti et dolorem tenetur tempore sit, officia, natus repellendus voluptas fuga nostrum? Minima, fuga saepe, 
                                        commodi repellendus praesentium odio mollitia facere reprehenderit consectetur repudiandae qui magni.
                                        Eveniet itaque necessitatibus excepturi maiores cupiditate at obcaecati debitis vitae, aperiam ad aspernatur incidunt veritatis recusandae, 
                                        quisquam saepe non a aliquid minima, esse rem. Eligendi, voluptate. Quos laboriosam nostrum culpa.
                                    </p>
                                </b-tab>
                            </b-tabs>
                        </b-card>
                    </div>

                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolor nostrum, id quam 
                        exercitationem aperiam laudantium aut soluta cupiditate impedit maiores fugiat consequatur quae quidem consequuntur 
                        inventore nihil? Debitis, cupiditate unde?
                        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Iure quod numquam, odit laborum ducimus temporibus nulla, 
                        provident veritatis rem eaque tenetur, corrupti non ipsa voluptas nihil commodi iusto culpa eius? Magnam eaque sit voluptatibus, 
                        eligendi laboriosam blanditiis eveniet quo debitis ipsum quam et laborum dolor veniam ea inventore dolorum deserunt corrupti error 
                        alias iure maiores natus molestias. Enim, velit optio.
                        Voluptate non fugiat dolores iste accusamus quaerat quos! Distinctio dolores asperiores unde ullam? Nam labore vitae nulla quo a. 
                        Eaque accusantium temporibus veritatis error sunt ut a, debitis vero ex!
                    </p>
                    
                    <div id="staff" class="mt-3 mb-3">
                        <!-- Tabs to provide information on Students -->
                        <b-card
                        header-bg-variant="dark"
                        header-text-variant="light"
                        header-html="<h2>Staff</h2>"
                        header-class="text-center"
                        text-variant="dark"
                        no-body
                        >
                            <b-tabs card fill
                            active-nav-item-class="font-weight-bold bg-light"
                            >
                                <b-tab title="Registral">I'm the first fading tab</b-tab>

                                <b-tab title="School Of Electrical And Computing Engineering">

                                    I'm the second tab
                                    <b-card>I'm the card in tab</b-card>
                                </b-tab>

                                <b-tab title="School Of Mechanical And Chemical Engineering">I'm the last tab</b-tab>
                            </b-tabs>
                        </b-card>
                    </div>

                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Cupiditate ut eos ex odio necessitatibus omnis. 
                        Laudantium atque ratione, iure consequatur similique inventore quis dignissimos minima doloribus, repellendus voluptas tenetur quo?
                        Aut, saepe, a, similique cupiditate reprehenderit minus nulla non quasi distinctio reiciendis mollitia eos? Ea rem, iusto, delectus fuga odio laudantium 
                        sint exercitationem maiores asperiores non ut quo quisquam ipsam.
                        Recusandae nisi ex nam. Non incidunt voluptates voluptatibus assumenda mollitia praesentium tenetur illum laboriosam quia natus, nostrum quisquam commodi sequi, 
                        nesciunt dolorem soluta animi dolorum. Odit dolores ea non cum.
                        Odio ut similique eligendi sint, autem amet libero voluptatum? Itaque mollitia rem ut obcaecati facilis recusandae doloremque fuga repellendus quas ducimus dolor 
                        voluptas praesentium facere dignissimos inventore, sed quia temporibus.
                        Ipsum molestiae harum quasi saepe expedita dignissimos quas animi enim alias ut magni, fugit est totam, delectus, exercitationem in accusantium minus? Maxime fugit optio 
                        temporibus laboriosam iste nemo ratione alias!
                        Aperiam, recusandae cumque? Eaque, molestias. Expedita, eius fugiat! Fugiat fugit, inventore libero ducimus quo dolor cumque facilis voluptates similique, ea suscipit harum 
                        expedita nemo corrupti dolore tempora? Veritatis, accusamus velit?
                        Eius tempore accusantium laborum. Laboriosam sequi officia pariatur ratione, et repudiandae explicabo quasi sit recusandae. Maxime accusantium quasi consequatur beatae non ut 
                        nulla atque dolorum dicta, est sint magnam recusandae?
                        Voluptatem est, ullam officiis et quia veritatis perferendis nisi quis architecto aut iusto eius enim nostrum? Iusto, molestias voluptatum ullam saepe placeat veniam optio labore 
                        deleniti, veritatis, eum nulla repudiandae.
                    </p>

                </b-container>
            </b-col>
            <b-col cols="3">
                <div style="position: fixed;">
                    <b-breadcrumb>
                        <b-breadcrumb-item>
                            <router-link to="/"><b-icon icon="house-fill" scale="1.25" shift-v="1.25" aria-hidden="true"></b-icon>
                                Home
                            </router-link>
                        </b-breadcrumb-item>
                        <b-breadcrumb-item>
                            <router-link to="/online">
                                Online
                            </router-link>
                        </b-breadcrumb-item>
                        <b-breadcrumb-item active>Info</b-breadcrumb-item>
                    </b-breadcrumb>

                    <div>
                        <b-card title="Title" header-tag="header" footer-tag="footer">
                        <template #header>
                            <h6 class="mb-0">Header Slot</h6>
                        </template>
                        <b-card-text>Header and footers using slots.</b-card-text>
                        <b-button href="#" variant="primary">Go somewhere</b-button>
                        <template #footer>
                            <em>Footer Slot</em>
                        </template>
                        </b-card>
                    </div>
                </div>

            </b-col>
        </b-row>
    </b-container>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';

export default {
    data() {
        return {
          tabIndex: 0,
          isVisible: false, // starts un-collapsed
          affairs:[],
        }
    },
    computed:{
        
    },
    methods: {
        getAffairs(){
            axios.get('/api/affairs')
            .then(resp => {
                this.affairs = resp.data.affairs;
            })
        }
    },
    created(){
        this.getAffairs()
    }
}
</script>

<style scoped>

</style>