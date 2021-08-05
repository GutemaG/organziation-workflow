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
                        header-bg-variant="dark"
                        header-text-variant="light"
                        header-html="<h2><strong>Affairs</strong></h2>"
                        text-variant="dark"
                        header-class="text-center"
                        no-body
                        >
                            <b-tabs card 
                            active-nav-item-class="font-weight-bold bg-info"
                            >
                                <b-tab title="All">
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
                                                <b-card header-bg-variant="dark" header-text-variant="white">
                                                    <template #header class="text-center">
                                                        <div class="d-flex align-items-center">
                                                            <b-icon icon="info-circle-fill" class="mr-3" scale="2" variant="info"></b-icon>
                                                            <h4 class="mb-0">{{ affair.name }}</h4>
                                                        </div>
                                                    </template>


                                                    <!-- Via array of string IDs passed to directive value -->
                                                    <div v-for="procedure in affair.procedures" :key="procedure.id">
                                                        <b-button 
                                                        block pill 
                                                        variant="outline-info text-dark"
                                                        v-b-toggle="'procedures'+procedure.id"
                                                        class="d-flex mt-2"
                                                        style="border-color: white !important;">
                                                            <b-badge pill class="mr-2 d-flex align-items-center" variant="primary">Step {{ procedure.step }}</b-badge>
                                                            {{ procedure.name }}
                                                        </b-button>

                                                        <!-- Elements to collapse -->
                                                        <b-collapse :id="'procedures'+procedure.id" class="mt-2 mb-2">
                                                            <b-card>
                                                                <h3><strong>Description</strong></h3>
                                                                <p>
                                                                    {{ procedure.description }}
                                                                </p>
                                                                <div v-if="procedure.pre_requests.length > 0">
                                                                    <strong>Pre-requests required: </strong>
                                                                    <div>
                                                                        <b-list-group v-for="pre_request, index in procedure.pre_requests" :key="pre_request.id">
                                                                            <b-list-group-item variant="" class="d-flex align-items-center mb-1" v-b-toggle="'pre_requests'+pre_request.id">
                                                                                <b-badge pill class="mr-2" font-scale="2" variant="secondary">{{ index+1 }}</b-badge>
                                                                                <span>{{ pre_request.name }}</span>
                                                                            </b-list-group-item>
                                                                            
                                                                            <!-- Toggle pre_requests -->
                                                                            <b-card-group>
                                                                                <b-collapse :id="'pre_requests'+pre_request.id">
                                                                                    <b-card border-variant="light" class="mb-1">
                                                                                        <h5><strong>Description</strong></h5>
                                                                                        <p>{{ pre_request.description }}</p>
                                                                                    </b-card>
                                                                                </b-collapse>
                                                                            </b-card-group>
                                                                        </b-list-group>
                                                                    </div>
                                                                </div>
                                                            </b-card>
                                                        </b-collapse>
                                                    </div>
                                                </b-card>
                                            </b-card-group>
                                        </b-col>
                                    </b-row>
                                </b-tab>

                                <b-tab title="Student">
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

                                <b-tab title="Staff">
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