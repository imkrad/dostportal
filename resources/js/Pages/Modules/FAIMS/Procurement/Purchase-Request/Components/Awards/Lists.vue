<template>
    <PageHeader v-if="option == 'awards'" title="Awards" pageTitle="Bids" />
    <div>
        <b-row class="g-2 mb-2 mt-n2">
             
             <BCol>     
                 REMARK STATUS        
                 <b-badge 
                     :variant="getBadgeVariant('Pending')" 
                     style="color: white;"
                     class="m-1"
                     >
                     Pending 
                     <i class="ri-close-line align-bottom me-1"></i>
                 </b-badge>  
                 <b-badge 
                     :variant="getBadgeVariant('For Bids')" 
                     style="color: white;"
                     class="m-1">
                     For Bids  
                     <i class="ri-wallet-line"></i>           
                 </b-badge>  
                 <b-badge 
                     :variant="getBadgeVariant('Awarded')" 
                     style="color: white;"
                     class="m-1">
                     Awarded
                     <i class="ri-check-line"></i>
                 </b-badge>  
             </BCol>
           
         </b-row>
     
        <b-row class="">
           
            <!-- <b-col  lg="11">
                    <Multiselect 
                    :options=" lists.suppliers " 
                    v-model="supplier_id"
                    :searchable="true" label="name"
                    placeholder="Select Supplier"/>
                  
            </b-col > -->


        <b-row class="g-2 mb-3 mt-n2">
            <b-col lg>
                <div class="input-group mb-1">
                    <span class="input-group-text"> <i class="ri-search-line search-icon"></i></span>
                    <input type="text" v-model="filter.keyword" placeholder="Search Bids" class="form-control" style="width: 60%;">
                    <span @click="refresh()" class="input-group-text" v-b-tooltip.hover title="Refresh" style="cursor: pointer;"> 
                        <i class="bx bx-refresh search-icon"></i>
                    </span>
                    <b-button type="button" variant="primary" @click="setBidPrice(dropdowns.data,'for_all_items')">
                        <i class="ri-add-circle-fill align-bottom me-1"></i> Create
                    </b-button>
                </div>
            </b-col>
          
        </b-row>
      
         </b-row>
         <b-row class="align-items-center">
  <!-- Left Content -->
  <b-col>
    <th class="font-weight-bold">
      PURCHASE REQUEST NO:
      <u class="text-info">
        <span class="bg-light p-1">
          {{ dropdowns.data.purchase_request_number }}
        </span>
      </u>
    </th>
  </b-col>

        <!-- Right-Aligned Action Button -->
        <b-col class="text-end">
            <b-dropdown size="sm" variant="success">
            <template #button-content>
                <b>Actions</b>
            </template>
            <b-dropdown-item @click="printBids(dropdowns.data)">
                <i class="ri-printer-line align-bottom me-1"></i> 
                Print
            </b-dropdown-item>
            </b-dropdown>
        </b-col>
        </b-row>
    </div>

    <div class="horizontal-scroll-tabs">
        <b-tabs class="bg-white" card>
        <b-tab v-for="(item, index) in dropdowns.lists.data" :key="index" :title="item.supplier.name">
            <div class="chat-wrapper d-lg-flex gap-1 mx-n4 mt-n1 p-1">
                <div class="file-manager-content w-100 p-4 pb-0" style="height: calc(80vh - 180px); overflow: auto;" ref="box">
                    <div>
                    <table class="table  mb-0">
                        <thead class="table-light">
                            <tr class="fs-11">
                                <th>#</th>
                                <th>Status</th>
                                <th>Item Description</th> 
                                <th>Quantity/Unit</th>
                                <th>ABC</th>
                                <th>Bid Price</th>
                                <th>Total Bid Price</th>
                                <th>Remarks</th> 
        
                            </tr>
                        </thead>

                
                        <tbody>
                            <tr v-for="(item, index) in  dropdowns.lists.data[index].bids_details " :key="index">
                                <td>{{ index + 1 }}</td>
                                <td>   
                                    <b-badge 
                                        v-if="item.status"
                                        :variant="getBadgeVariant(item.status.name)" 
                                        style="color: white;">
                                        {{ item.status.name }} 
                                        <i v-if="item.status.name == 'Pending for Award'" class="ri-close-line"></i>
                                        <i v-if="item.status.name == 'Not Available for Award'" class="ri-wallet-line"></i>
                                        <i v-if="item.status.name == 'Available for Award'"class="ri-check-line"></i>
                                        <i v-if="item.status.name == 'Awarded'"class="ri-check-line"></i>
                                    </b-badge>  
                                
                                </td>      
                                <td>
                                    <div v-html="item.bids_description"></div>
                                </td>

                                    
                                <td>
                                    {{ item.bids_quantity }} {{ item.unit_type.name_long }} 
                                 </td>
                                <td>
                                    {{ formatCurrency(item.bids_abc) }}
                                </td>
                                <td>
                                    {{ formatCurrency(item.bids_price) }}
                                </td>
                                <td>
                                    {{ formatCurrency(item.bids_quantity * item.bids_price) }}
                                </td>
                                <td>
                                    {{  item.remarks }}
                                </td>
                              
                            </tr>
                        </tbody>
                    </table>
                    <Pagination class="ms-2 me-2" v-if="meta" @fetch="fetch" :lists="lists.length" :links="links" :pagination="meta" />
                    </div> 

                    
                </div>
            </div>
        </b-tab>
        </b-tabs>
    </div>

 

    <Create :dropdowns="dropdowns" :items="dropdowns.item_details" ref="create"/>
</template>
<script>
// import Lists from './Procurement/Purchase-Request/Components/Lists.vue';
import _ from 'lodash';
import PageHeader from '@/Shared/Components/PageHeader.vue';
import { useForm } from '@inertiajs/vue3';
import Multiselect from "@vueform/multiselect";
import InputError from '@/Shared/Components/Forms/InputError.vue';
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
import TextInput from '@/Shared/Components/Forms/TextInput.vue';
import Checkbox from '@/Shared/Components/Forms/Checkbox.vue';
import Create from '../../Modals/CreateBids.vue';
import { router } from '@inertiajs/vue3';

export default {
    components: {Create, PageHeader, InputError, InputLabel, TextInput, Multiselect, Checkbox },
    props: ['dropdowns', 'lists' , 'option'],
    data(){
        return {
            currentUrl: window.location.origin,
            lists: [],
            bids_details: [],
            meta: {},
            links: {},
            filter: {
                keyword: null,
            },
            index: null
        }
    },

    // created(){
    //     this.fetch();
    // },


    methods: { 
        // checkSearchStr: _.debounce(function(string) {
        //     this.fetch();
        // }, 300),
        // fetch(page_url){ 
        //     page_url = '/faims/bids' ;
        //     axios.get(page_url,{
        //         params : {
        //             keyword: this.filter.keyword,
        //             option: 'lists',
        //             purchase_request_id: this.dropdowns.data.id,
        //         }
        //     })
        //     .then(response => {
        //         if(response){
        //             this.lists = response.data.data;
        //             this.meta = response.data.meta;
        //             this.links = response.data.links;          
        //         }
        //     })
        //     .catch(err => console.log(err));
        // },

        // fetchBidsDetails(page_url){ 
        //     page_url = '/faims/bids' ;
        //     axios.get(page_url,{
        //         params : {
        //             keyword: this.filter.keyword,
        //             option: 'bids_details',
        //             bids_id: this.dropdowns.data.id,
        //             purchase_request_id: this.dropdowns.data.purchase_request.id,
        //         }
        //     })
        //     .then(response => {
        //         if(response){
        //             this.bids_details = response.data.data;
        //             this.meta = response.data.meta;
        //             this.links = response.data.links;          
        //         }
        //     })
        //     .catch(err => console.log(err));
        // },

        openAddBids(){
            this.$refs.create.show();
        },

        setBidPrice(data , type){
            this.$refs.create.edit(data , type);
           
        },

        awardPR(data){
            this.$refs.create.edit(data , 'award_pr');
        },

        getCurrentDate() {
            const today = new Date();
            const year = today.getFullYear();
            const month = String(today.getMonth() + 1).padStart(2, '0'); // Months are zero-based
            const day = String(today.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        },
   
        formatCurrency(value) {
            return new Intl.NumberFormat('en-PH', {
            style: 'currency',
            currency: 'PHP',
            }).format(value);
        },
        getBadgeVariant(status_name) {
            switch (status_name) {
                case 'Pending':
                    return 'danger'; // Maps to Bootstrap's warning variant
                case 'For Bids':
                    return 'info';    // Maps to Bootstrap's info variant
                case 'Awarded':
                    return 'success';  // Maps to Bootstrap's success variant
                default:
                    return 'secondary'; // Default variant if none match
            }
        },

        goBackPage(){
            this.$inertia.visit('/faims/quotation-requests');
        },

        printBids(data){
            console.log(data);
           window.open('/faims/bids/print/'+data.id+'?pr_id='+ data.id +'&purchase_request_number='+data.purchase_request_number );
        }

        

    }
}
</script>

<style scoped>
/* Enable horizontal scrolling for tabs */
.horizontal-scroll-tabs {
  overflow-x: auto;
  white-space: nowrap;
  border: 1px solid #ddd;
  border-radius: 8px;
  padding: 10px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.horizontal-scroll-tabs::-webkit-scrollbar {
  height: 8px;
}

.horizontal-scroll-tabs::-webkit-scrollbar-thumb {
  background: #888; /* Thumb color */
  border-radius: 4px;
}

.horizontal-scroll-tabs::-webkit-scrollbar-thumb:hover {
  background: #555; /* Thumb hover color */
}

/* Keep tabs in a single line */
.horizontal-scroll-tabs .nav-tabs {
  flex-wrap: nowrap;
}

.horizontal-scroll-tabs .nav-item {
  display: inline-block;
  margin-right: 5px;
}

.horizontal-scroll-tabs .nav-link {
  white-space: normal; /* Ensure tab titles wrap if they're long */
  text-align: center;
}
</style>