<template>
    <PageHeader title="Suppliers" pageTitle="Libraries" />
    <b-row class="g-2 mb-3 mt-n2">
        <b-col lg>
            <div class="input-group mb-1">
                <span class="input-group-text"> <i class="ri-search-line search-icon"></i></span>
                <input type="text" v-model="filter.keyword" placeholder="Search PAP Code" class="form-control" style="width: 60%;">
                <span @click="refresh()" class="input-group-text" v-b-tooltip.hover title="Refresh" style="cursor: pointer;"> 
                    <i class="bx bx-refresh search-icon"></i>
                </span>
                <b-button type="button" variant="primary" @click="openPAPCodModal()">
                    <i class="ri-add-circle-fill align-bottom me-1"></i> New
                </b-button>
            </div>
        </b-col>
    </b-row>
    <div class="chat-wrapper d-lg-flex gap-1 mx-n4 mt-n4 p-1">
    <div class="file-manager-content w-100 p-4 pb-0" style="height: calc(100vh - 180px); overflow: auto;" ref="box">
        <table class="table mb-0">
            <thead class="table-light">
                <tr class="fs-11">
                    <th>#</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Mayor's Permit No.</th>
                    <th>TIN</th>
                    <th>Actions</th>
                </tr>
            </thead>
           
            <tbody>
                    <tr class="custom-hover-row" v-for="(list, index) in lists" :key="index">
                        <td>{{ index + 1 }}</td>
                        <td>{{ list.name  }}</td>
                        <td>{{ list.address  }}</td>
                        <td>{{ list.mayors_permit_no  }}</td>
                        <td>{{ list.tin  }}</td>

                        <td>
                            <b-button @click="editPAP(list)" size="sm">
                                <i class="ri-file-fill align-bottom me-1"></i> <!-- Icon for Print -->
                                Edit
                            </b-button>
                        </td>
                    </tr>

                </tbody>

        </table>
        <Pagination class="ms-2 me-2" v-if="meta" @fetch="fetch" :lists="lists.length" :links="links" :pagination="meta" />
    </div> 
</div>


<SupplierModal @add="fetch()" @update="fetch()" :data="form" ref="create" />
</template>
<script>
import _ from 'lodash';
import PageHeader from '@/Shared/Components/PageHeader.vue';
import Pagination from "@/Shared/Components/Pagination.vue";
import { router } from '@inertiajs/vue3';
import SupplierModal from '@/Pages/Modules/FAIMS/Procurement/Libraries/Modals/Supplier.vue';

export default {
props: ['dropdowns'],
components: { SupplierModal, Pagination, PageHeader },
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
        page_url = '/faims/libraries/suppliers' ;
        axios.get(page_url,{
            params : {
                keyword: this.filter.keyword,
                option: 'lists',
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

    
    formatCurrency(value) {
        return new Intl.NumberFormat('en-PH', {
        style: 'currency',
        currency: 'PHP',
        }).format(value);
    },


    openPAPCodModal(){
        this.$refs.create.show();
    },


    editPAP(data){
        this.$refs.create.edit(data);
    },

    


  
}
}
</script>