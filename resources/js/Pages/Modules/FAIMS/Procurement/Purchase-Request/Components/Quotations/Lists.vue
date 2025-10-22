<template>
        <PageHeader title="Quotation Requests" pageTitle="List" />
        <b-row>
            <h5>
                <div>
                    <span class="font-weight-bold">
                            PR REQUEST NO:
                            <u class="text-info">
                            <span class="bg-light  p-1">
                                {{  purchase_request.purchase_request_number }}
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
                    <input type="text" v-model="filter.keyword" placeholder="Search Quotation Request" class="form-control" style="width: 60%;">
                    <span @click="refresh()" class="input-group-text" v-b-tooltip.hover title="Refresh" style="cursor: pointer;"> 
                        <i class="bx bx-refresh search-icon"></i>
                    </span>
                    <b-button type="button" variant="primary" @click="goCreatePage(purchase_request)">
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
                        <th>RFQ No.</th>
                        <th>Submission not later than</th>
                        <th>Supplier</th>
                        <th>Supply Officer</th>     
                        <th>Date Created</th>   
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    <tr class="custom-hover-row" v-for="(list, index) in lists" :key="index">
                        <td>{{ index + 1 }}</td>
                        <td>{{ list.rfq_no }}</td>
                        <td>{{ list.submission_not_later_than }}</td>
                        <td style="line-height: .1;">
                            <p>{{ list.supplier.name }}</p>
                            <p>
                            {{  list.supplier.address }}
                            </p>
                        </td>
                        <td>{{ list.supply_officer.firstname }} {{ list.supply_officer.middlename[0] }}. {{ list.supply_officer.lastname }} {{ list.supply_officer.suffix }}</td>
                        <td>{{  list.date }}</td>

                        <td>
                            <b-button @click="printPreview(list)" size="sm">
                                <i class="ri-printer-fill align-bottom me-1"></i> <!-- Icon for Print -->
                                Print
                            </b-button>
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


    
   
</template>
<script>
import _ from 'lodash';
import PageHeader from '@/Shared/Components/PageHeader.vue';
import Pagination from "@/Shared/Components/Pagination.vue";
import { router } from '@inertiajs/vue3';
export default {
    props: ['purchase_request'],
    components: { PageHeader,Pagination },
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
            page_url = '/faims/quotation-requests' ;
            axios.get(page_url,{
                params : {
                    keyword: this.filter.keyword,
                    option: 'quotation_request',
                    purchase_request_id: this.purchase_request.id,
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

        goCreatePage(data){
            router.get('/faims/quotation-requests/'+data.id, { option: 'create_rfq'  });
        },
    

        printPreview(data){
            window.open('/faims/quotations/request/print/'+data.id + '?purchase_request_number='+data.purchase_request.purchase_request_number 
                                        + '&purchase_request_id='+data.purchase_request.id
                                        + '&rfq_no='+data.rfq_no
                                        + '&supplier_id='+data.supplier.id 
                                        + '&address='+data.supplier.address
                                        + '&supplier_officer_id='+data.supply_officer.id
                                        + '&date_submitted='+data.submission_not_later_than
                                        + '&purchase_request_date='+data.date);
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