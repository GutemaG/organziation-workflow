<template>
    <b-container fluid>
        <b-row class="mt-3">
            <b-col>
                <b-container>
                    <h1 style="text-align: center;">ONLINE CENTER</h1>
                    <p>
                        Here you can access our organization's affairs that can help you with. Below you will see list of affairs and these lists of affairs have 
                        thier own way of procedures that will meet your need. Go ahead and click the tabs to view thier description.
                    </p>
                    
                    <div>
                        <!-- Tabs with card integration -->
                        <b-card no-body>
                        <b-tabs
                        active-nav-item-class="font-weight-bold bg-info text-uppercase" 
                        v-model="tabIndex" card>
                            <b-tab title="Regisral">
                                <h3>Lists of Affairs</h3>
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsum provident alias, ex quam officiis quia. 
                                    Provident neque ipsam rem. Facere corporis error voluptate sunt voluptas debitis, repellat dicta! Quibusdam, facere.
                                </p>
                                

                                <div>
                                    <b-row>
                                        <b-col cols="10">
                                            <b-card-group class="mb-3">
                                                <b-list-group class="d-flex w-100">
                                                    <b-list-group-item href="#">Awesome link</b-list-group-item>
                                                    <b-list-group-item href="#">Link with active state</b-list-group-item>
                                                    <b-list-group-item href="#">Action links are easy</b-list-group-item>
                                                    <b-list-group-item href="#">Disabled link</b-list-group-item>
                                                </b-list-group>
                                            </b-card-group>
                                        </b-col>
                                    </b-row>
                                </div>

                                <h3>ALSKDJ ALSKDJ </h3>
                                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. 
                                    Alias itaque deserunt recusandae magni, voluptate sed repellat ex. Deleniti quo est vitae praesentium aut commodi sed, asperiores sit debitis sapiente! Itaque?
                                </p>

                                <div>
                                    <b-row>
                                        <b-col cols="10">
                                            <b-card-group class="mb-3">
                                                <b-list-group class="d-flex">
                                                    <b-list-group-item href="#">Awesome link</b-list-group-item>
                                                    <b-list-group-item href="#">Link with active state</b-list-group-item>
                                                    <b-list-group-item href="#">Action links are easy</b-list-group-item>
                                                    <b-list-group-item href="#">Disabled link</b-list-group-item>
                                                </b-list-group>
                                            </b-card-group>
                                        </b-col>
                                    </b-row>
                                </div>

                            </b-tab>

                            <b-tab title="School Of Electrical">
                                <h3>Lists of Affairs</h3>
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsum provident alias, ex quam officiis quia. 
                                    Provident neque ipsam rem. Facere corporis error voluptate sunt voluptas debitis, repellat dicta! Quibusdam, facere.
                                </p>

                                <div>
                                    <b-row>
                                        <b-col cols="10">
                                            <b-card-group class="mb-3">
                                                <b-card header="Registerial" header-bg-variant="info" header-text-variant="dark">
                                                    
                                                    <!-- Via array of string IDs passed to directive value -->
                                                    <b-button block squared variant="outline" v-b-toggle="['collapse-a']" class="mb-2" style="text-align: left;">
                                                        <i class="fa fa-circle mr-2" aria-hidden="true"></i>For freshman students registration
                                                    </b-button>
                                                    <!-- Elements to collapse -->
                                                    <b-collapse id="collapse-a" class="mt-2">
                                                        <b-card>
                                                            <b-list-group>
                                                                <h5>The following lists are required: </h5>
                                                                <b-list-group-item button class="d-flex align-items-center">
                                                                    <b-badge class="mr-2" pill><i class="fa fa-angle-double-right" aria-hidden="true"></i></b-badge>
                                                                    12 Grade transcript
                                                                </b-list-group-item>
                                                                <b-list-group-item button class="d-flex align-items-center" v-b-toggle="['collapse-c']">
                                                                    <b-badge class="mr-2" pill><i class="fa fa-angle-double-down" aria-hidden="true"></i></b-badge>                                                            
                                                                    10 Grade transcript/click me to see other lists required/
                                                                </b-list-group-item>
                                                                <!-- toggle c -->
                                                                <b-card-group block>
                                                                    <b-collapse id="collapse-c" class="m-3">
                                                                        <b-card class="mt-2 mb-2">Lorem ipsum dolor sit amet consectetur adipisicing elit.</b-card>
                                                                        <b-card class="mt-2 mb-2">Lorem ipsum dolor sit amet consectetur adipisicing elit.</b-card>
                                                                        <b-card class="mt-2 mb-2">Lorem ipsum dolor sit amet consectetur adipisicing elit.</b-card>
                                                                    </b-collapse>
                                                                </b-card-group>
                                                                <b-list-group-item button class="d-flex align-items-center">
                                                                    <b-badge class="mr-2" pill><i class="fa fa-angle-double-right" aria-hidden="true"></i></b-badge>
                                                                    8 Grade transcript
                                                                </b-list-group-item>
                                                                <b-list-group-item button class="d-flex align-items-center" v-b-toggle="['collapse-b']">
                                                                    <b-badge class="mr-2" pill><i class="fa fa-angle-double-right" aria-hidden="true"></i></b-badge>
                                                                    Files
                                                                </b-list-group-item>
                                                                <!-- toggle b -->
                                                                <b-card-group block>
                                                                    <b-collapse id="collapse-b" class="m-3">
                                                                        <b-card>Lorem ipsum dolor sit amet consectetur adipisicing elit.</b-card>
                                                                    </b-collapse>
                                                                </b-card-group>
                                                            </b-list-group>
                                                        </b-card>
                                                    </b-collapse>

                                                    <!-- Via array of string IDs passed to directive value -->
                                                    <b-button block squared variant="outline" v-b-toggle="['collapse-a22']" class="mb-2" style="text-align: left;">
                                                        <i class="fa fa-circle mr-2" aria-hidden="true"></i>For registration
                                                    </b-button>
                                                    <!-- Elements to collapse -->
                                                    <b-collapse id="collapse-a22" class="mt-2">
                                                        <b-card>
                                                            <b-list-group>
                                                                <h5>The following lists are required: </h5>
                                                                <b-list-group-item button class="d-flex align-items-center">
                                                                    <b-badge class="mr-2" pill><i class="fa fa-angle-double-right" aria-hidden="true"></i></b-badge>
                                                                    12 Grade transcript
                                                                </b-list-group-item>
                                                                <b-list-group-item button class="d-flex align-items-center" v-b-toggle="['collapse-c22']">
                                                                    <b-badge class="mr-2" pill><i class="fa fa-angle-double-down" aria-hidden="true"></i></b-badge>                                                            
                                                                    10 Grade transcript/click me to see other lists required/
                                                                </b-list-group-item>
                                                                <!-- toggle c -->
                                                                <b-card-group block>
                                                                    <b-collapse id="collapse-c22" class="m-3">
                                                                        <b-card class="mt-2 mb-2">Lorem ipsum dolor sit amet consectetur adipisicing elit.</b-card>
                                                                        <b-card class="mt-2 mb-2">Lorem ipsum dolor sit amet consectetur adipisicing elit.</b-card>
                                                                        <b-card class="mt-2 mb-2">Lorem ipsum dolor sit amet consectetur adipisicing elit.</b-card>
                                                                    </b-collapse>
                                                                </b-card-group>
                                                                <b-list-group-item button class="d-flex align-items-center">
                                                                    <b-badge class="mr-2" pill><i class="fa fa-angle-double-right" aria-hidden="true"></i></b-badge>
                                                                    8 Grade transcript
                                                                </b-list-group-item>
                                                                <b-list-group-item button class="d-flex align-items-center" v-b-toggle="['collapse-b22']">
                                                                    <b-badge class="mr-2" pill><i class="fa fa-angle-double-right" aria-hidden="true"></i></b-badge>
                                                                    Files
                                                                </b-list-group-item>
                                                                <!-- toggle b -->
                                                                <b-card-group block>
                                                                    <b-collapse id="collapse-b22" class="m-3">
                                                                        <b-card>Lorem ipsum dolor sit amet consectetur adipisicing elit.</b-card>
                                                                    </b-collapse>
                                                                </b-card-group>
                                                            </b-list-group>
                                                        </b-card>
                                                    </b-collapse>

                                                    <!-- Via array of string IDs passed to directive value -->
                                                    <b-button block squared variant="outline" v-b-toggle="['collapse-a33']" class="mb-2" style="text-align: left;">
                                                        <i class="fa fa-circle mr-2" aria-hidden="true"></i>For registration
                                                    </b-button>
                                                    <!-- Elements to collapse -->
                                                    <b-collapse id="collapse-a33" class="mt-2">
                                                        <b-card>
                                                            <b-list-group>
                                                                <h5>The following lists are required: </h5>
                                                                <b-list-group-item button class="d-flex align-items-center">
                                                                    <b-badge class="mr-2" pill><i class="fa fa-angle-double-right" aria-hidden="true"></i></b-badge>
                                                                    12 Grade transcript
                                                                </b-list-group-item>
                                                                <b-list-group-item button class="d-flex align-items-center" v-b-toggle="['collapse-c33']">
                                                                    <b-badge class="mr-2" pill><i class="fa fa-angle-double-down" aria-hidden="true"></i></b-badge>                                                            
                                                                    10 Grade transcript/click me to see other lists required/
                                                                </b-list-group-item>
                                                                <!-- toggle c -->
                                                                <b-card-group block>
                                                                    <b-collapse id="collapse-c33" class="m-3">
                                                                        <b-card class="mt-2 mb-2">Lorem ipsum dolor sit amet consectetur adipisicing elit.</b-card>
                                                                        <b-card class="mt-2 mb-2">Lorem ipsum dolor sit amet consectetur adipisicing elit.</b-card>
                                                                        <b-card class="mt-2 mb-2">Lorem ipsum dolor sit amet consectetur adipisicing elit.</b-card>
                                                                    </b-collapse>
                                                                </b-card-group>
                                                                <b-list-group-item button class="d-flex align-items-center">
                                                                    <b-badge class="mr-2" pill><i class="fa fa-angle-double-right" aria-hidden="true"></i></b-badge>
                                                                    8 Grade transcript
                                                                </b-list-group-item>
                                                                <b-list-group-item button class="d-flex align-items-center" v-b-toggle="['collapse-b33']">
                                                                    <b-badge class="mr-2" pill><i class="fa fa-angle-double-right" aria-hidden="true"></i></b-badge>
                                                                    Files
                                                                </b-list-group-item>
                                                                <!-- toggle b -->
                                                                <b-card-group block>
                                                                    <b-collapse id="collapse-b33" class="m-3">
                                                                        <b-card>Lorem ipsum dolor sit amet consectetur adipisicing elit.</b-card>
                                                                    </b-collapse>
                                                                </b-card-group>
                                                            </b-list-group>
                                                        </b-card>
                                                    </b-collapse>

                                                </b-card>
                                            </b-card-group>
                                        </b-col>
                                    </b-row>
                                </div>

                                <h3>ALSKDJ ALSKDJ </h3>
                                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. 
                                    Alias itaque deserunt recusandae magni, voluptate sed repellat ex. Deleniti quo est vitae praesentium aut commodi sed, asperiores sit debitis sapiente! Itaque?
                                </p>

                                <div>
                                    <b-row>
                                        <b-col cols="10">
                                            <b-card-group class="mb-3">
                                                <b-card header="Registerial2" header-bg-variant="info" header-text-variant="dark">
                                                    <!-- Via array of string IDs passed to directive value -->
                                                    <b-button block squared variant="outline" v-b-toggle="['collapse-a1']" class="mb-2" style="text-align: left;">
                                                        <i class="fa fa-circle mr-2" aria-hidden="true"></i>For freshman students registration
                                                    </b-button>

                                                    <!-- Elements to collapse -->
                                                    <b-collapse id="collapse-a1" class="mt-2">
                                                        <b-card>
                                                            <b-list-group>
                                                                <h5>The following lists are required: </h5>
                                                                <b-list-group-item button class="d-flex align-items-center">
                                                                    <b-badge class="mr-2" pill><i class="fa fa-angle-double-right" aria-hidden="true"></i></b-badge>
                                                                    12 Grade transcript
                                                                </b-list-group-item>
                                                                <b-list-group-item button class="d-flex align-items-center" v-b-toggle="['collapse-c1']">
                                                                    <b-badge class="mr-2" pill><i class="fa fa-angle-double-right" aria-hidden="true"></i></b-badge>
                                                                    10 Grade transcript/click me to see other lists required/
                                                                </b-list-group-item>
                                                                
                                                                <!-- toggle c -->
                                                                <b-card-group block>
                                                                    <b-collapse id="collapse-c1" class="m-3">
                                                                        <b-card class="mt-2 mb-2">Lorem ipsum dolor sit amet consectetur adipisicing elit.</b-card>
                                                                        <b-card class="mt-2 mb-2">Lorem ipsum dolor sit amet consectetur adipisicing elit.</b-card>
                                                                        <b-card class="mt-2 mb-2">Lorem ipsum dolor sit amet consectetur adipisicing elit.</b-card>
                                                                    </b-collapse>
                                                                </b-card-group>

                                                                <b-list-group-item button class="d-flex align-items-center">
                                                                    <b-badge class="mr-2" pill><i class="fa fa-angle-double-right" aria-hidden="true"></i></b-badge>
                                                                    8 Grade transcript
                                                                </b-list-group-item>
                                                                <b-list-group-item button class="d-flex align-items-center" v-b-toggle="['collapse-b1']">
                                                                    <b-badge class="mr-2" pill><i class="fa fa-angle-double-right" aria-hidden="true"></i></b-badge>
                                                                    Files
                                                                </b-list-group-item>

                                                                <!-- toggle b -->
                                                                <b-card-group block>
                                                                    <b-collapse id="collapse-b1" class="m-3">
                                                                        <b-card>Lorem ipsum dolor sit amet consectetur adipisicing elit.</b-card>
                                                                    </b-collapse>
                                                                </b-card-group>
                                                            </b-list-group>
                                                        </b-card>
                                                    </b-collapse>
                                                </b-card>
                                            </b-card-group>
                                        </b-col>
                                    </b-row>
                                </div>

                            </b-tab>
                            <b-tab title="School Of Mechanical">
                                <h3>Lists of Affairs</h3>
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsum provident alias, ex quam officiis quia. 
                                    Provident neque ipsam rem. Facere corporis error voluptate sunt voluptas debitis, repellat dicta! Quibusdam, facere.
                                </p>

                                <div>
                                    <b-row>
                                        <b-col cols="10">
                                            <b-card-group class="mb-3">
                                                <b-card header="Registerial" header-bg-variant="info" header-text-variant="dark">
                                                    
                                                    <!-- Via array of string IDs passed to directive value -->
                                                    <b-button block squared variant="outline" v-b-toggle="['collapse-a']" class="mb-2" style="text-align: left;">
                                                        <i class="fa fa-circle mr-2" aria-hidden="true"></i>For freshman students registration
                                                    </b-button>
                                                    <!-- Elements to collapse -->
                                                    <b-collapse id="collapse-a" class="mt-2">
                                                        <b-card>
                                                            <b-list-group>
                                                                <h5>The following lists are required: </h5>
                                                                <div style="background-color: bisque; padding: 0.7rem;">
                                                                    <b-form @submit="onSubmit" @reset="onReset" v-if="show">
                                                                    <b-form-group
                                                                        id="input-group-1"
                                                                        label="Email address:"
                                                                        label-for="input-1"
                                                                        description="We'll never share your email with anyone else."
                                                                    >
                                                                        <b-form-input
                                                                        id="input-1"
                                                                        v-model="form.email"
                                                                        type="email"
                                                                        placeholder="Enter email"
                                                                        required
                                                                        ></b-form-input>
                                                                    </b-form-group>

                                                                    <b-form-group id="input-group-2" label="Your Name:" label-for="input-2">
                                                                        <b-form-input
                                                                        id="input-2"
                                                                        v-model="form.name"
                                                                        placeholder="Enter name"
                                                                        required
                                                                        ></b-form-input>
                                                                    </b-form-group>

                                                                    <b-form-group id="input-group-3" label="Food:" label-for="input-3">
                                                                        <b-form-select
                                                                        id="input-3"
                                                                        v-model="form.food"
                                                                        :options="foods"
                                                                        required
                                                                        ></b-form-select>
                                                                    </b-form-group>

                                                                    <b-form-group>
                                                                        <div class="py-2 d-flex align-items-left">
                                                                            <!-- Plain mode -->
                                                                            <b-form-file multiple v-model="file" plain ref="file-input" size="sm">    
                                                                            </b-form-file>
                                                                            <b-button pill variant="primary" class="mt-2" size="sm" @click="file = null">
                                                                                Clear selected files!
                                                                            </b-button>
                                                                        </div>
                                                                    </b-form-group>

                                                                    <b-button type="submit" variant="primary">Submit</b-button>
                                                                    <b-button type="reset" variant="danger">Reset</b-button>
                                                                    </b-form>
                                                                </div>
                                                            </b-list-group>
                                                        </b-card>
                                                    </b-collapse>

                                                    <!-- Via array of string IDs passed to directive value -->
                                                    <b-button block squared variant="outline" v-b-toggle="['collapse-a22']" class="mb-2" style="text-align: left;">
                                                        <i class="fa fa-circle mr-2" aria-hidden="true"></i>For registration
                                                    </b-button>
                                                    <!-- Elements to collapse -->
                                                    <b-collapse id="collapse-a22" class="mt-2">
                                                        <b-card>
                                                            <b-list-group>
                                                                <h5>The following lists are required: </h5>
                                                                <b-list-group-item button class="d-flex align-items-center">
                                                                    <b-badge class="mr-2" pill><i class="fa fa-angle-double-right" aria-hidden="true"></i></b-badge>
                                                                    12 Grade transcript
                                                                </b-list-group-item>
                                                                <b-list-group-item button class="d-flex align-items-center" v-b-toggle="['collapse-c22']">
                                                                    <b-badge class="mr-2" pill><i class="fa fa-angle-double-down" aria-hidden="true"></i></b-badge>                                                            
                                                                    10 Grade transcript/click me to see other lists required/
                                                                </b-list-group-item>
                                                                <!-- toggle c -->
                                                                <b-card-group block>
                                                                    <b-collapse id="collapse-c22" class="m-3">
                                                                        <b-card class="mt-2 mb-2">Lorem ipsum dolor sit amet consectetur adipisicing elit.</b-card>
                                                                        <b-card class="mt-2 mb-2">Lorem ipsum dolor sit amet consectetur adipisicing elit.</b-card>
                                                                        <b-card class="mt-2 mb-2">Lorem ipsum dolor sit amet consectetur adipisicing elit.</b-card>
                                                                    </b-collapse>
                                                                </b-card-group>
                                                                <b-list-group-item button class="d-flex align-items-center">
                                                                    <b-badge class="mr-2" pill><i class="fa fa-angle-double-right" aria-hidden="true"></i></b-badge>
                                                                    8 Grade transcript
                                                                </b-list-group-item>
                                                                <b-list-group-item button class="d-flex align-items-center" v-b-toggle="['collapse-b22']">
                                                                    <b-badge class="mr-2" pill><i class="fa fa-angle-double-right" aria-hidden="true"></i></b-badge>
                                                                    Files
                                                                </b-list-group-item>
                                                                <!-- toggle b -->
                                                                <b-card-group block>
                                                                    <b-collapse id="collapse-b22" class="m-3">
                                                                        <b-card>Lorem ipsum dolor sit amet consectetur adipisicing elit.</b-card>
                                                                    </b-collapse>
                                                                </b-card-group>
                                                            </b-list-group>
                                                        </b-card>
                                                    </b-collapse>

                                                    <!-- Via array of string IDs passed to directive value -->
                                                    <b-button block squared variant="outline" v-b-toggle="['collapse-a33']" class="mb-2" style="text-align: left;">
                                                        <i class="fa fa-circle mr-2" aria-hidden="true"></i>For registration
                                                    </b-button>
                                                    <!-- Elements to collapse -->
                                                    <b-collapse id="collapse-a33" class="mt-2">
                                                        <b-card>
                                                            <b-list-group>
                                                                <h5>The following lists are required: </h5>
                                                                <b-list-group-item button class="d-flex align-items-center">
                                                                    <b-badge class="mr-2" pill><i class="fa fa-angle-double-right" aria-hidden="true"></i></b-badge>
                                                                    12 Grade transcript
                                                                </b-list-group-item>
                                                                <b-list-group-item button class="d-flex align-items-center" v-b-toggle="['collapse-c33']">
                                                                    <b-badge class="mr-2" pill><i class="fa fa-angle-double-down" aria-hidden="true"></i></b-badge>                                                            
                                                                    10 Grade transcript/click me to see other lists required/
                                                                </b-list-group-item>
                                                                <!-- toggle c -->
                                                                <b-card-group block>
                                                                    <b-collapse id="collapse-c33" class="m-3">
                                                                        <b-card class="mt-2 mb-2">Lorem ipsum dolor sit amet consectetur adipisicing elit.</b-card>
                                                                        <b-card class="mt-2 mb-2">Lorem ipsum dolor sit amet consectetur adipisicing elit.</b-card>
                                                                        <b-card class="mt-2 mb-2">Lorem ipsum dolor sit amet consectetur adipisicing elit.</b-card>
                                                                    </b-collapse>
                                                                </b-card-group>
                                                                <b-list-group-item button class="d-flex align-items-center">
                                                                    <b-badge class="mr-2" pill><i class="fa fa-angle-double-right" aria-hidden="true"></i></b-badge>
                                                                    8 Grade transcript
                                                                </b-list-group-item>
                                                                <b-list-group-item button class="d-flex align-items-center" v-b-toggle="['collapse-b33']">
                                                                    <b-badge class="mr-2" pill><i class="fa fa-angle-double-right" aria-hidden="true"></i></b-badge>
                                                                    Files
                                                                </b-list-group-item>
                                                                <!-- toggle b -->
                                                                <b-card-group block>
                                                                    <b-collapse id="collapse-b33" class="m-3">
                                                                        <b-card>Lorem ipsum dolor sit amet consectetur adipisicing elit.</b-card>
                                                                    </b-collapse>
                                                                </b-card-group>
                                                            </b-list-group>
                                                        </b-card>
                                                    </b-collapse>

                                                </b-card>
                                            </b-card-group>
                                        </b-col>
                                    </b-row>
                                </div>

                                <h3>ALSKDJ ALSKDJ </h3>
                                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. 
                                    Alias itaque deserunt recusandae magni, voluptate sed repellat ex. Deleniti quo est vitae praesentium aut commodi sed, asperiores sit debitis sapiente! Itaque?
                                </p>

                                <div>
                                    <b-row>
                                        <b-col cols="10">
                                            <b-card-group class="mb-3">
                                                <b-card header="Registerial2" header-bg-variant="info" header-text-variant="dark">
                                                    <!-- Via array of string IDs passed to directive value -->
                                                    <b-button block squared variant="outline" v-b-toggle="['collapse-a1']" class="mb-2" style="text-align: left;">
                                                        <i class="fa fa-circle mr-2" aria-hidden="true"></i>For freshman students registration
                                                    </b-button>

                                                    <!-- Elements to collapse -->
                                                    <b-collapse id="collapse-a1" class="mt-2">
                                                        <b-card>
                                                            <b-list-group>
                                                                <h5>The following lists are required: </h5>
                                                                <b-list-group-item button class="d-flex align-items-center">
                                                                    <b-badge class="mr-2" pill><i class="fa fa-angle-double-right" aria-hidden="true"></i></b-badge>
                                                                    12 Grade transcript
                                                                </b-list-group-item>
                                                                <b-list-group-item button class="d-flex align-items-center" v-b-toggle="['collapse-c1']">
                                                                    <b-badge class="mr-2" pill><i class="fa fa-angle-double-right" aria-hidden="true"></i></b-badge>
                                                                    10 Grade transcript/click me to see other lists required/
                                                                </b-list-group-item>
                                                                
                                                                <!-- toggle c -->
                                                                <b-card-group block>
                                                                    <b-collapse id="collapse-c1" class="m-3">
                                                                        <b-card class="mt-2 mb-2">Lorem ipsum dolor sit amet consectetur adipisicing elit.</b-card>
                                                                        <b-card class="mt-2 mb-2">Lorem ipsum dolor sit amet consectetur adipisicing elit.</b-card>
                                                                        <b-card class="mt-2 mb-2">Lorem ipsum dolor sit amet consectetur adipisicing elit.</b-card>
                                                                    </b-collapse>
                                                                </b-card-group>

                                                                <b-list-group-item button class="d-flex align-items-center">
                                                                    <b-badge class="mr-2" pill><i class="fa fa-angle-double-right" aria-hidden="true"></i></b-badge>
                                                                    8 Grade transcript
                                                                </b-list-group-item>
                                                                <b-list-group-item button class="d-flex align-items-center" v-b-toggle="['collapse-b1']">
                                                                    <b-badge class="mr-2" pill><i class="fa fa-angle-double-right" aria-hidden="true"></i></b-badge>
                                                                    Files
                                                                </b-list-group-item>

                                                                <!-- toggle b -->
                                                                <b-card-group block>
                                                                    <b-collapse id="collapse-b1" class="m-3">
                                                                        <b-card>Lorem ipsum dolor sit amet consectetur adipisicing elit.</b-card>
                                                                    </b-collapse>
                                                                </b-card-group>
                                                            </b-list-group>
                                                        </b-card>
                                                    </b-collapse>
                                                </b-card>
                                            </b-card-group>
                                        </b-col>
                                    </b-row>
                                </div>

                            </b-tab>
                            <b-tab title="School Of Civil">
                                <h3>Lists of Affairs</h3>
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsum provident alias, ex quam officiis quia. 
                                    Provident neque ipsam rem. Facere corporis error voluptate sunt voluptas debitis, repellat dicta! Quibusdam, facere.
                                </p>

                                <div>
                                    <b-row>
                                        <b-col cols="10">
                                            <b-card-group class="mb-3">
                                               <b-list-group>
                                                    <b-list-group-item href="#">Awesome link</b-list-group-item>
                                                    <b-list-group-item href="#">Link with active state</b-list-group-item>
                                                    <b-list-group-item href="#">Action links are easy</b-list-group-item>
                                                    <b-list-group-item href="#">Disabled link</b-list-group-item>
                                                </b-list-group>
                                            </b-card-group>
                                        </b-col>
                                    </b-row>
                                </div>

                                <h3>ALSKDJ ALSKDJ </h3>
                                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. 
                                    Alias itaque deserunt recusandae magni, voluptate sed repellat ex. Deleniti quo est vitae praesentium aut commodi sed, asperiores sit debitis sapiente! Itaque?
                                </p>

                                <div>
                                    <b-row>
                                        <b-col cols="10">
                                            <b-card-group class="mb-3">
                                                <b-list-group>
                                                    <b-list-group-item href="#">Awesome link</b-list-group-item>
                                                    <b-list-group-item href="#">Link with active state</b-list-group-item>
                                                    <b-list-group-item href="#">Action links are easy</b-list-group-item>
                                                    <b-list-group-item href="#">Disabled link</b-list-group-item>
                                                </b-list-group>
                                            </b-card-group>
                                        </b-col>
                                    </b-row>
                                </div>

                            </b-tab>
                        </b-tabs>
                        </b-card>

                        <!-- Control buttons-->
                        <div class="text-center">
                            <b-button-group class="mt-3 mb-3">
                                <b-button class="mr-3" @click="tabIndex--">Previous</b-button>
                                <b-button @click="tabIndex++">Next</b-button>
                            </b-button-group>
                        </div>
                    </div>
                    
                </b-container>
            </b-col>
            <b-col cols="3">
                <div style="position: fixed;">
                    <b-breadcrumb>
                        <b-breadcrumb-item>
                            <router-link to="/"><b-icon icon="house-fill" scale="1.25" shift-v="1.25" aria-hidden="true"></b-icon>
                            Home</router-link>
                            
                        </b-breadcrumb-item>
                        <b-breadcrumb-item>
                            <router-link to="/info">Info</router-link>
                        </b-breadcrumb-item>
                        <b-breadcrumb-item active>Online</b-breadcrumb-item>
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
          tabIndex: 0,
          isVisible: false, // starts un-collapsed
          file: null,
          form: {
              email: '',
              name: '',
              food: null,
              checked: []
            },
        foods: [{ text: 'Select One', value: null }, 'Carrots', 'Beans', 'Tomatoes', 'Corn'],
        show: true
      }
    },
    methods: {
        clearFiles() {
        this.$refs['file-input'].reset()
      },
      onSubmit(event) {
        event.preventDefault()
        alert(JSON.stringify(this.form))
      },
      onReset(event) {
        event.preventDefault()
        // Reset our form values
        this.form.email = ''
        this.form.name = ''
        this.form.food = null
        this.form.checked = []
        // Trick to reset/clear native browser form validation state
        this.show = false
        this.$nextTick(() => {
          this.show = true
        })
      }
    }
  }
</script>