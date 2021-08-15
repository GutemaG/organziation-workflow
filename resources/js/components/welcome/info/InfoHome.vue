<template>
    <b-container fluid>
        <b-row>
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

                    <div class="mt-3 mb-3">
                        <!-- Tabs to provide information -->
                        <div class="card shadow shadow-lg--hover" style="border-radius: 1.2rem 1.2rem;">
                            <div class="card-header text-center shadow" 
                            style="background-color: #343a40 !important; color: white; border-radius: 1.2rem 1.2rem 0rem 0;">
                                <h2><strong>Affair Information</strong></h2>
                            </div>
                            <b-tabs card pills no-fade vertical
                            active-nav-item-class="font-weight-bold bg-info"
                            >
                                <b-tab title="All">
                                    <h3>List of All affairs</h3>
                                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. 
                                        Numquam, culpa. Sint, a laborum quia porro molestias vero consequatur pariatur aut similique at mollitia 
                                        ratione sapiente explicabo. Ipsa voluptatem consequuntur culpa.
                                        Quae ab beatae eos cupiditate voluptatem, dolorum impedit fugiat explicabo perspiciatis autem illo 
                                        consequatur unde necessitatibus perferendis, accusamus totam dignissimos, esse ut blanditiis at libero iste! 
                                        Saepe eos voluptate voluptatibus.
                                    </p>

                                    <!-- For list of affairs -->
                                    <div class="m-2">
                                        <b-input-group style="max-width: 24rem;">
                                            <b-form-input
                                            id="filter-input"
                                            type="search"
                                            placeholder="Type to Search"
                                            ></b-form-input>

                                            <b-input-group-append>
                                            <button type="button" class="btn btn-dark" style="border-radius: none;" @click="filterKey = ''">{{ tr("Clear") }}</button>
                                            </b-input-group-append>
                                        </b-input-group>
                                        <hr>
                                    </div>
                                    <b-row>
                                        <b-col style="height: 80vh; overflow-y: scroll">
                                            <div style="display: inline-block; width: 80%">
                                                <b-card-group class="" v-for="affair in affairs" :key="affair.id">
                                                    <div class="card mb-3 mt-3 justify-content-md-center shadow shadow-lg--hover" 
                                                    style="border-radius: 1.36rem; border: 1px solid rgba(0, 0, 0, 0.125);">
                                                        <div class="card-header text-center shadow" 
                                                            style="background-color: #6c757d !important; color: white; border-radius: 1.25rem 1.25rem 0rem 0;">
                                                            <div class="d-flex justify-content-md-center align-items-center">
                                                                <b-icon icon="info-circle-fill" class="mr-3" scale="2" variant="info"></b-icon>
                                                                <h4 class="mb-0">{{ affair.name }}</h4>
                                                            </div>
                                                        </div>


                                                        <!-- Via array of string IDs passed to directive value -->
                                                        <div class="card-body align-items-center"
                                                        style="border: 1px solid rgba(0, 0, 0, 0.228);
                                                        border-radius: 0 0 1.25rem 1.25rem;">
                                                            <div style="" class="timeline" v-for="procedure in affair.procedures" :key="procedure.id">
                                                                <div 
                                                                    variant="outline-info"
                                                                    v-b-toggle="'procedures'+procedure.id"
                                                                    class="d-flex align-items-center time-label"
                                                                    style="border-color: white !important;"
                                                                    :active="procedure.id"
                                                                    >
                                                                    <i class="fas bg-blue">{{ procedure.step }}</i>
                                                                    <div class="timeline-item"
                                                                    style="
                                                                    width: 100%;
                                                                    border: 1px solid rgba(0, 0, 0, 0.125);">
                                                                        <div class="timeline-header shadow" style="border-bottom: 0;">
                                                                            {{ procedure.name }}
                                                                        </div>
                                                                    </div>

                                                                </div>

                                                                <!-- Elements to collapse -->
                                                                <b-collapse :id="'procedures'+procedure.id" 
                                                                class="timeline-item pl-4">
                                                                    <div class="timeline-body d-flex justify-content-md-center">
                                                                        <b-card style="max-width: 90%; border-radius: 1.25rem ; border: 1px solid rgba(0, 0, 0, 0.125);"
                                                                        class="shadow shadow-lg--hover">
                                                                            <h3><strong>Description</strong></h3>
                                                                            <hr>
                                                                            <p>
                                                                                {{ procedure.description }}
                                                                            </p>
                                                                            <div v-if="procedure.pre_requests.length > 0">
                                                                                <strong>Pre-requests required: </strong>
                                                                                <div class="mt-2 w-70">
                                                                                    <div class="list-group" style="border-radius: 2rem" v-for="pre_request, index in procedure.pre_requests" :key="pre_request.id">
                                                                                        <b-list-group-item href="#" variant="dark"
                                                                                        class="d-flex align-items-center mb-1" v-b-toggle="'pre_requests'+pre_request.id">
                                                                                            <b-badge pill class="mr-2" variant="dark">{{ index+1 }}</b-badge>
                                                                                            <span>{{ pre_request.name }}</span>
                                                                                        </b-list-group-item>
                                                                                        
                                                                                        <!-- Toggle pre_requests -->
                                                                                        <b-card-group>
                                                                                            <b-collapse :id="'pre_requests'+pre_request.id">
                                                                                                <b-card  style="border-radius: 1.25rem; border: 1.8px solid rgba(0, 0, 0, 0.125);" 
                                                                                                class="mt-2 mb-2 shadow shadow-lg--hover">
                                                                                                    <h5><strong>Description</strong></h5>
                                                                                                    <hr>
                                                                                                    <p>{{ pre_request.description }}</p>
                                                                                                </b-card>
                                                                                            </b-collapse>
                                                                                        </b-card-group>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </b-card>
                                                                    </div>
                                                                </b-collapse>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                </b-card-group>
                                            </div>
                                        </b-col>
                                    </b-row>
                                </b-tab>

                                <b-tab title="Student">

                                    <h2>List of Student affairs</h2>
                                    <p>
                                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Doloribus quasi nihil at quis vel voluptates id nostrum ratione, 
                                        autem voluptate nobis suscipit ipsum quia quo vero esse, neque, non ullam.
                                        Tempore ullam illo, aspernatur repellendus qui accusantium totam sit cumque repudiandae error quam eveniet. Qui fugiat quod 
                                        libero quibusdam laboriosam, possimus ea recusandae repellendus labore sequi, temporibus nihil, saepe nisi.
                                    </p>

                                    <div>
                                        <b-card-group v-for="affair in affairs" :key="affair.id">
                                            <div v-if="affair.type == 'student'" 
                                                class="card mb-3 mt-3 shadow shadow-lg--hover" 
                                                style="max-width: 70%; border-radius: 1.36rem; border: 1px solid rgba(0, 0, 0, 0.125);">
                                                <div class="card-header text-center shadow" 
                                                    style="background-color: #6c757d !important; color: white; border-radius: 1.25rem 1.25rem 0rem 0;">
                                                    <div class="d-flex align-items-center">
                                                        <b-icon icon="info-circle-fill" class="mr-3" scale="2" variant="info"></b-icon>
                                                        <h4 class="mb-0">{{ affair.name }}</h4>
                                                    </div>
                                                </div>


                                                <!-- Via array of string IDs passed to directive value -->
                                                <div style="padding: 8px" class="container" v-for="procedure in affair.procedures" :key="procedure.id">
                                                    <b-button 
                                                    pill block
                                                    variant="outline-info text-dark"
                                                    v-b-toggle="'procedures'+procedure.id"
                                                    class="d-flex align-items-center"
                                                    style="border-color: white !important;">
                                                        <b-badge pill class="d-flex mr-3 align-items-center" variant="primary">Step {{ procedure.step }}</b-badge>
                                                        {{ procedure.name }}
                                                    </b-button>

                                                    <!-- Elements to collapse -->
                                                    <b-collapse :id="'procedures'+procedure.id" 
                                                    class="mt-2 mb-2">
                                                        <div class=" d-flex justify-content-md-center">
                                                            <b-card style="max-width: 90%; border-radius: 1.25rem; border: 1.6px solid rgba(0, 0, 0, 0.125);"
                                                            class="shadow shadow-lg--hover">
                                                                <h3><strong>Description</strong></h3>
                                                                <hr>
                                                                <p>
                                                                    {{ procedure.description }}
                                                                </p>
                                                                <div v-if="procedure.pre_requests.length > 0">
                                                                    <strong>Pre-requests required: </strong>
                                                                    <div class="mt-2">
                                                                        <div class="list-group" style="border-radius: 2rem" v-for="pre_request, index in procedure.pre_requests" :key="pre_request.id">
                                                                            <b-list-group-item href="#" variant="dark" class="d-flex align-items-center mb-1" v-b-toggle="'pre_requests'+pre_request.id">
                                                                                <b-badge pill class="mr-2" font-scale="2" variant="dark">{{ index+1 }}</b-badge>
                                                                                <span>{{ pre_request.name }}</span>
                                                                            </b-list-group-item>
                                                                            
                                                                            <!-- Toggle pre_requests -->
                                                                            <b-card-group>
                                                                                <b-collapse :id="'pre_requests'+pre_request.id">
                                                                                    <b-card  style="border-radius: 1.25rem; border: 1.8px solid rgba(0, 0, 0, 0.125);" 
                                                                                    class="mt-2 mb-2 shadow shadow-lg--hover">
                                                                                        <h5><strong>Description</strong></h5>
                                                                                        <hr>
                                                                                        <p>{{ pre_request.description }}</p>
                                                                                    </b-card>
                                                                                </b-collapse>
                                                                            </b-card-group>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </b-card>
                                                        </div>
                                                    </b-collapse>
                                                </div>
                                            </div>
                                        </b-card-group>
                                    </div>
                                    
                                </b-tab>

                                <b-tab title="Staff">

                                    <h2>List of Staff affairs</h2>
                                    <p>
                                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Doloribus quasi nihil at quis vel voluptates id nostrum ratione, 
                                        autem voluptate nobis suscipit ipsum quia quo vero esse, neque, non ullam.
                                        Tempore ullam illo, aspernatur repellendus qui accusantium totam sit cumque repudiandae error quam eveniet. Qui fugiat quod 
                                        libero quibusdam laboriosam, possimus ea recusandae repellendus labore sequi, temporibus nihil, saepe nisi.
                                    </p>

                                    <div>
                                        <b-card-group v-for="affair in affairs" :key="affair.id">
                                            <div v-if="affair.type == 'staff'" 
                                                class="card mb-3 mt-3 shadow shadow-lg--hover" 
                                                style="max-width: 70%; border-radius: 1.36rem; border: 1px solid rgba(0, 0, 0, 0.125);">
                                                <div class="card-header text-center shadow" 
                                                    style="background-color: #6c757d !important; color: white; border-radius: 1.25rem 1.25rem 0rem 0;">
                                                    <div class="d-flex align-items-center">
                                                        <b-icon icon="info-circle-fill" class="mr-3" scale="2" variant="info"></b-icon>
                                                        <h4 class="mb-0">{{ affair.name }}</h4>
                                                    </div>
                                                </div>


                                                <!-- Via array of string IDs passed to directive value -->
                                                <div style="padding: 8px" class="container" v-for="procedure in affair.procedures" :key="procedure.id">
                                                    <b-button 
                                                    pill block
                                                    variant="outline-info text-dark"
                                                    v-b-toggle="'procedures'+procedure.id"
                                                    class="d-flex align-items-center"
                                                    style="border-color: white !important;">
                                                        <b-badge pill class="d-flex mr-3 align-items-center" variant="primary">Step {{ procedure.step }}</b-badge>
                                                        {{ procedure.name }}
                                                    </b-button>

                                                    <!-- Elements to collapse -->
                                                    <b-collapse :id="'procedures'+procedure.id" 
                                                    class="mt-2 mb-2">
                                                        <div class=" d-flex justify-content-md-center">
                                                            <b-card style="max-width: 90%; border-radius: 1.25rem; border: 1.6px solid rgba(0, 0, 0, 0.125);"
                                                            class="shadow shadow-lg--hover">
                                                                <h3><strong>Description</strong></h3>
                                                                <hr>
                                                                <p>
                                                                    {{ procedure.description }}
                                                                </p>
                                                                <div v-if="procedure.pre_requests.length > 0">
                                                                    <strong>Pre-requests required: </strong>
                                                                    <div class="mt-2">
                                                                        <div class="list-group" style="border-radius: 2rem" v-for="pre_request, index in procedure.pre_requests" :key="pre_request.id">
                                                                            <b-list-group-item href="#" variant="dark" class="d-flex align-items-center mb-1" v-b-toggle="'pre_requests'+pre_request.id">
                                                                                <b-badge pill class="mr-2" font-scale="2" variant="dark">{{ index+1 }}</b-badge>
                                                                                <span>{{ pre_request.name }}</span>
                                                                            </b-list-group-item>
                                                                            
                                                                            <!-- Toggle pre_requests -->
                                                                            <b-card-group>
                                                                                <b-collapse :id="'pre_requests'+pre_request.id">
                                                                                    <b-card  style="border-radius: 1.25rem; border: 1.8px solid rgba(0, 0, 0, 0.125);" 
                                                                                    class="mt-2 mb-2 shadow shadow-lg--hover">
                                                                                        <h5><strong>Description</strong></h5>
                                                                                        <hr>
                                                                                        <p>{{ pre_request.description }}</p>
                                                                                    </b-card>
                                                                                </b-collapse>
                                                                            </b-card-group>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </b-card>
                                                        </div>
                                                    </b-collapse>
                                                </div>
                                            </div>
                                        </b-card-group>
                                    </div>

                                </b-tab>

                                <b-tab title="Teacher">

                                    <h2>List of Teacher affairs</h2>
                                    <p>
                                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Doloribus quasi nihil at quis vel voluptates id nostrum ratione, 
                                        autem voluptate nobis suscipit ipsum quia quo vero esse, neque, non ullam.
                                        Tempore ullam illo, aspernatur repellendus qui accusantium totam sit cumque repudiandae error quam eveniet. Qui fugiat quod 
                                        libero quibusdam laboriosam, possimus ea recusandae repellendus labore sequi, temporibus nihil, saepe nisi.
                                    </p>

                                    <div>
                                        <b-card-group v-for="affair in affairs" :key="affair.id">
                                            <div v-if="affair.type == 'teacher'" 
                                                class="card mb-3 mt-3 shadow shadow-lg--hover" 
                                                style="max-width: 70%; border-radius: 1.36rem; border: 1px solid rgba(0, 0, 0, 0.125);">
                                                <div class="card-header text-center shadow" 
                                                    style="background-color: #6c757d !important; color: white; border-radius: 1.25rem 1.25rem 0rem 0;">
                                                    <div class="d-flex align-items-center">
                                                        <b-icon icon="info-circle-fill" class="mr-3" scale="2" variant="info"></b-icon>
                                                        <h4 class="mb-0">{{ affair.name }}</h4>
                                                    </div>
                                                </div>


                                                <!-- Via array of string IDs passed to directive value -->
                                                <div style="padding: 8px" class="container" v-for="procedure in affair.procedures" :key="procedure.id">
                                                    <b-button 
                                                    pill block
                                                    variant="outline-info text-dark"
                                                    v-b-toggle="'procedures'+procedure.id"
                                                    class="d-flex align-items-center"
                                                    style="border-color: white !important;">
                                                        <b-badge pill class="d-flex mr-3 align-items-center" variant="primary">Step {{ procedure.step }}</b-badge>
                                                        {{ procedure.name }}
                                                    </b-button>

                                                    <!-- Elements to collapse -->
                                                    <b-collapse :id="'procedures'+procedure.id" 
                                                    class="mt-2 mb-2">
                                                        <div class=" d-flex justify-content-md-center">
                                                            <b-card style="max-width: 90%; border-radius: 1.25rem; border: 1.6px solid rgba(0, 0, 0, 0.125);"
                                                            class="shadow shadow-lg--hover">
                                                                <h3><strong>Description</strong></h3>
                                                                <hr>
                                                                <p>
                                                                    {{ procedure.description }}
                                                                </p>
                                                                <div v-if="procedure.pre_requests.length > 0">
                                                                    <strong>Pre-requests required: </strong>
                                                                    <div class="mt-2">
                                                                        <div class="list-group" style="border-radius: 2rem" v-for="pre_request, index in procedure.pre_requests" :key="pre_request.id">
                                                                            <b-list-group-item href="#" variant="dark" class="d-flex align-items-center mb-1" v-b-toggle="'pre_requests'+pre_request.id">
                                                                                <b-badge pill class="mr-2" font-scale="2" variant="dark">{{ index+1 }}</b-badge>
                                                                                <span>{{ pre_request.name }}</span>
                                                                            </b-list-group-item>
                                                                            
                                                                            <!-- Toggle pre_requests -->
                                                                            <b-card-group>
                                                                                <b-collapse :id="'pre_requests'+pre_request.id">
                                                                                    <b-card  style="border-radius: 1.25rem; border: 1.8px solid rgba(0, 0, 0, 0.125);" 
                                                                                    class="mt-2 mb-2 shadow shadow-lg--hover">
                                                                                        <h5><strong>Description</strong></h5>
                                                                                        <hr>
                                                                                        <p>{{ pre_request.description }}</p>
                                                                                    </b-card>
                                                                                </b-collapse>
                                                                            </b-card-group>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </b-card>
                                                        </div>
                                                    </b-collapse>
                                                </div>
                                            </div>
                                        </b-card-group>
                                    </div>

                                </b-tab>

                                <b-tab title="Other">

                                    <h2>List of Other affairs</h2>
                                    <p>
                                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Doloribus quasi nihil at quis vel voluptates id nostrum ratione, 
                                        autem voluptate nobis suscipit ipsum quia quo vero esse, neque, non ullam.
                                        Tempore ullam illo, aspernatur repellendus qui accusantium totam sit cumque repudiandae error quam eveniet. Qui fugiat quod 
                                        libero quibusdam laboriosam, possimus ea recusandae repellendus labore sequi, temporibus nihil, saepe nisi.
                                    </p>

                                    <div>
                                        <b-card-group v-for="affair in affairs" :key="affair.id">
                                            <div v-if="affair.type == 'other'" 
                                                class="card mb-3 mt-3 shadow shadow-lg--hover" 
                                                style="max-width: 70%; border-radius: 1.36rem; border: 1px solid rgba(0, 0, 0, 0.125);">
                                                <div class="card-header text-center shadow" 
                                                    style="background-color: #6c757d !important; color: white; border-radius: 1.25rem 1.25rem 0rem 0;">
                                                    <div class="d-flex align-items-center">
                                                        <b-icon icon="info-circle-fill" class="mr-3" scale="2" variant="info"></b-icon>
                                                        <h4 class="mb-0">{{ affair.name }}</h4>
                                                    </div>
                                                </div>


                                                <!-- Via array of string IDs passed to directive value -->
                                                <div style="padding: 8px" class="container" v-for="procedure in affair.procedures" :key="procedure.id">
                                                    <b-button 
                                                    pill block
                                                    variant="outline-info text-dark"
                                                    v-b-toggle="'procedures'+procedure.id"
                                                    class="d-flex align-items-center"
                                                    style="border-color: white !important;">
                                                        <b-badge pill class="d-flex mr-3 align-items-center" variant="primary">Step {{ procedure.step }}</b-badge>
                                                        {{ procedure.name }}
                                                    </b-button>

                                                    <!-- Elements to collapse -->
                                                    <b-collapse :id="'procedures'+procedure.id" 
                                                    class="mt-2 mb-2">
                                                        <div class=" d-flex justify-content-md-center">
                                                            <b-card style="max-width: 90%; border-radius: 1.25rem; border: 1.6px solid rgba(0, 0, 0, 0.125);"
                                                            class="shadow shadow-lg--hover">
                                                                <h3><strong>Description</strong></h3>
                                                                <hr>
                                                                <p>
                                                                    {{ procedure.description }}
                                                                </p>
                                                                <div v-if="procedure.pre_requests.length > 0">
                                                                    <strong>Pre-requests required: </strong>
                                                                    <div class="mt-2">
                                                                        <div class="list-group" style="border-radius: 2rem" v-for="pre_request, index in procedure.pre_requests" :key="pre_request.id">
                                                                            <b-list-group-item href="#" variant="dark" class="d-flex align-items-center mb-1" v-b-toggle="'pre_requests'+pre_request.id">
                                                                                <b-badge pill class="mr-2" font-scale="2" variant="dark">{{ index+1 }}</b-badge>
                                                                                <span>{{ pre_request.name }}</span>
                                                                            </b-list-group-item>
                                                                            
                                                                            <!-- Toggle pre_requests -->
                                                                            <b-card-group>
                                                                                <b-collapse :id="'pre_requests'+pre_request.id">
                                                                                    <b-card  style="border-radius: 1.25rem; border: 1.8px solid rgba(0, 0, 0, 0.125);" 
                                                                                    class="mt-2 mb-2 shadow shadow-lg--hover">
                                                                                        <h5><strong>Description</strong></h5>
                                                                                        <hr>
                                                                                        <p>{{ pre_request.description }}</p>
                                                                                    </b-card>
                                                                                </b-collapse>
                                                                            </b-card-group>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </b-card>
                                                        </div>
                                                    </b-collapse>
                                                </div>
                                            </div>
                                        </b-card-group>
                                    </div>

                                </b-tab>

                            </b-tabs>
                        </div>
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
export default {
    data() {
        return {
        affairs: [],
        selectedAffair: null,
        };
    },
    methods: {
        getAffairs(){
            axios.get('/api/affairs')
            .then(resp => {
                this.affairs = resp.data.affairs;
            })
        },
        selectAffair(affair) {
            this.selectedAffair = affair;
        },
        selectedListIndex(id) {
            if (this.selectedAffair) {
                if (this.selectedAffair.id == id) {
                return true;
                }
            }
            return false;
        }
    },
    created(){
        this.getAffairs()
    }
}
</script>

<style scoped>
.timeline-header:hover{
    background-color: #007bff;
    color: #fff !important;
    transform: scale(1.03);
}
</style>