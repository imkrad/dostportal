<template>
    <PageHeader title="BAC Resolutions" pageTitle="List" />
    <b-row>
        <h5>
            <div>
                <span class="font-weight-bold">
                        PR REQUEST NO:
                        <u class="text-info">
                        <span class="bg-light  p-1">
                            {{  dropdowns.data.purchase_request_number }}
                        </span>
                    </u>
                </span>
        </div>
        </h5>
    </b-row>
    <b-row class="g-2 mb-3 mt-n2">
        <b-col lg>
            <div class="input-group mb-1">
                <span class="input-group-text"> <i class="ri-search-line search-icon"></i></span>
                <input type="text" v-model="filter.keyword" placeholder="Search BAC Resolutions" class="form-control" style="width: 60%;">
                <span @click="refresh()" class="input-group-text" v-b-tooltip.hover title="Refresh" style="cursor: pointer;"> 
                    <i class="bx bx-refresh search-icon"></i>
                </span>
                <b-button type="button" variant="primary" @click="openBACReso()">
                    <i class="ri-add-circle-fill align-bottom me-1"></i> New
                </b-button>
            </div>
        </b-col>
    </b-row>


    <div class="chat-wrapper d-lg-flex gap-1 mx-n4 mt-n4 p-1">
    <div class="file-manager-content w-100 p-4 pb-0" style="height: calc(90vh - 180px); overflow: auto;" ref="box">
        <table class="table mb-0">
            <thead class="table-light">
                <tr class="fs-11">
                    <th>#</th>
                    <th>BAC Resolution No.</th>  
                    <th>Date Created</th>   
                    <th></th>
                </tr>
            </thead>

            <tbody>
                <tr class="custom-hover-row" v-for="(list, index) in lists" :key="index">
                    <td>{{ index + 1 }}</td>
                    <td>{{ list.bac_resolution_number }}</td>
                    <td>{{ list.created_at }}</td>

                    <td>
                        <span>
                            <b-button @click="printBACReso(list)" size="sm" >
                                <i class="ri-printer-fill align-bottom me-1"></i> <!-- Icon for Print -->
                                Print
                            </b-button>
                        </span>
                        <span style="margin-left: 10px;">
                            <b-button @click="editBACReso(list)" size="sm " class="bg-success border border-none" >
                                <i class="ri-file-fill align-bottom me-1"></i> <!-- Icon for Print -->
                                Edit
                            </b-button>
                       </span>
                    </td>
                </tr>

            </tbody>
        </table>
        <Pagination class="ms-2 me-2" v-if="meta" @fetch="fetch" :lists="lists.length" :links="links" :pagination="meta" />
    </div> 
</div>

<b-button type="button" variant="primary" style=" background: grey; color: white" class="m-3" @click="goBackPage()">
    <i class="ri-arrow-left-line align-bottom me-1"></i> Back
</b-button>

<GenerateBACResoModal  :bids="dropdowns.bids" :data="dropdowns.data" ref="BACReso"/>

</template>
<script>
import _ from 'lodash';

import PageHeader from '@/Shared/Components/PageHeader.vue';
import Pagination from "@/Shared/Components/Pagination.vue";
import GenerateBACResoModal from '@/Pages/Modules/FAIMS/Procurement/Purchase-Request/Modals/GenerateBACResolution.vue';
import { router } from '@inertiajs/vue3';
export default {
props: ['dropdowns'],
components: { PageHeader, Pagination, GenerateBACResoModal },
data(){
    return {
        currentUrl: window.location.origin,
        lists: [],
        meta: {},
        links: {},
        filter: {
            keyword: null,
        },
        index: null
    }
},
watch: {
    "filter.keyword"(newVal){
        this.checkSearchStr(newVal);
    }
},
created(){
    this.fetch();
},
methods: {
    checkSearchStr: _.debounce(function(string) {
        this.fetch();
    }, 300),
    fetch(page_url){ 
        page_url = '/faims/bac-resolutions' ;
        axios.get(page_url,{
            params : {
                keyword: this.filter.keyword,
                option: 'lists',
                purchase_request_id: this.dropdowns.data.id,
            }
        })
        .then(response => {
            if(response){
                this.lists = response.data.data;
                this.meta = response.data.meta;
                this.links = response.data.links;          
            }
        })
        .catch(err => console.log(err));

    },

    openBACReso(){
        if(this.dropdowns.data.status_id == 7 ){
            this.$refs.BACReso.show();
        }

    },

    editBACReso(data){

        if(this.dropdowns.data.status_id == 8 ){
            this.$refs.BACReso.edit(data);
        }
    },

    

    printBACReso(data){
        window.open('/faims/BACReso/print/'+data.id);
    },

    goBackPage(){
        this.$inertia.visit('/faims/quotation-requests');
    },
}
}
</script>

<style scoped>
.custom-hover-row:hover {
background-color: hsl(0, 29%, 97%); 
}

</style>