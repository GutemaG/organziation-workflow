<template>
    <b-container fluid>
        <b-row class="mt-3">
            <b-col>
                <b-container>
                    <h1 style="text-align: center;">INFORMATION CENTER</h1>
                    <p>
                        Here you can access our organization's affairs that can help you with. Below you will see list of affairs and these lists of affairs have 
                        thier own way of procedures that will meet your need. Go ahead and click the tabs to view thier description.
                    </p>
                    <div style="height: 100vh;">
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
                                                <b-card header="Registerial" header-bg-variant="info" header-text-variant="dark">
                                                    
                                                    <!-- Via array of string IDs passed to directive value -->
                                                    <b-button block squared variant="outline" v-b-toggle="['collapse-a']" class="mb-2" style="text-align: left;">
                                                        <b-icon v-if="isVisible" icon="arrow-down-square-fill" scale="1.2" variant="secondary"></b-icon>
                                                        <b-icon v-else icon="arrow-right-square-fill" scale="1.2" variant="success"></b-icon>
                                                        
                                                        For freshman students registration
                                                    </b-button>
                                                    <!-- Elements to collapse -->
                                                    <b-collapse id="collapse-a" class="mt-2" v-model="isVisible">
                                                        <b-card>
                                                            <b-list-group>
                                                                <h5>The following lists are required: </h5>
                                                                <b-list-group-item button class="d-flex align-items-center">
                                                                    <b-icon class="mr-2" icon="check-circle-fill" scale="1.2" variant="success"></b-icon>
                                                                    12 Grade transcript
                                                                </b-list-group-item>
                                                                <b-list-group-item button class="d-flex align-items-center" v-b-toggle="['collapse-c']">
                                                                    <b-icon class="mr-2" icon="plus-circle-fill" scale="1.2" variant="success"></b-icon>                                                          
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
                                                                    <b-icon class="mr-2" icon="check-circle-fill" scale="1.2" variant="success"></b-icon>
                                                                    8 Grade transcript
                                                                </b-list-group-item>
                                                                <b-list-group-item button class="d-flex align-items-center" v-b-toggle="['collapse-b']">
                                                                    <b-icon class="mr-2" icon="plus-circle-fill" scale="1.2" variant="success"></b-icon>
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
                            <b-tab title="School Of Civil">
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
                        </b-tabs>
                        </b-card>

                        <!-- Control buttons-->
                        <div class="text-center">
                            <b-button-group class="mt-3 mb-3">
                                <b-button class="mr-3" @click="tabIndex--">Previous</b-button>
                                <b-button @click="tabIndex++">Next</b-button>
                            </b-button-group>
                        </div>
                        {{ affairs }}
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
                            <router-link to="/online">Online</router-link>
                        </b-breadcrumb-item>
                        <b-breadcrumb-item active>Info</b-breadcrumb-item>
                    </b-breadcrumb>

                    <b-group>
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
                    </b-group>
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
        //   affairs:[]
        }
    },
    computed:{
        ...mapGetters(['affairs'])
        // totalAffairs(){
        //     return this.affairs.length
        // },
        // first(){
        //     return this.affairs[0]
        // }
    },
    methods: {
        ...mapActions(['fetchAffairs']),
        // getAffairs(){
        //     axios.get('/api/affairs').then(resp => {
        //         console.log(resp)
        //         this.affairs = resp.data.affairs
        //     })
        // }
    },
    created(){
        this.fetchAffairs()
        // this.$store.dispatch('fetchAffairs')
        // this.getAffairs()
    }
}
</script>