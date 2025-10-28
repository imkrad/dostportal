<template>
    <PageHeader v-if="option == 'bids'" title="Abstract of Bids" pageTitle="Bids" />
    <div>
         <b-row class="align-items-center">
        <!-- Left Content -->
        <b-container card>
            <b-col>
                <th class="font-weight-bold;" style="border:none" >
                PURCHASE REQUEST NO:
                <u class="text-info">
                    <span class="bg-light p-1">
                    {{ purchase_request.purchase_request_number }}
                    </span>
                </u>
                </th>
            </b-col>

        </b-container>

        <!-- Right-Aligned Action Button -->
        <b-col class="text-end">
            <b-dropdown size="sm" variant="success">
            <template #button-content>
                <b>Actions</b>
            </template>
            <b-dropdown-item @click="printBids(purchase_request)">
                <i class="ri-printer-line align-bottom me-1"></i> 
                Print
            </b-dropdown-item>
            <b-dropdown-item @click="openBACReso()" v-if="purchase_request.status_id == 6">
                <i class="ri-file-line align-bottom me-1"></i> 
                BAC Resolution
            </b-dropdown-item>
            <b-dropdown-item @click="openNoticeOfAward()"  v-if="purchase_request.status_id == 8" >
                <i class="ri-file-line align-bottom me-1"></i> 
                Notice of Award(NOA)
            </b-dropdown-item>
          
            </b-dropdown>
        </b-col>
        </b-row>
    </div>
    
     <div class="horizontal-scroll-tabs m-0" card >
        <b-tabs class="bg-white " card>
        <b-tab v-for="(bid, bidIndex) in bids" :key="bid.bid_id">
            <template #title>
                {{ bid.supplier.name }}
              
                <b-badge variant="primary" v-if="getCheckedBidsCount(bid.bid_items) > 0">
                    {{ getCheckedBidsCount(bid.bid_items) }}
                </b-badge>
            </template>
            <div>
                <div class="file-manager-content w-100 pt-2 pb-0" style="height: calc(80vh - 180px); overflow: auto;" ref="box">
                    <div>
                    <table style="width:100%; border-collapse: collapse; border: 1px solid">
                        <thead>
                            <tr>
                            <th style="width: 2px;">Item No</th>
                            <th style="width: 20px;">Status</th>
                            <th style="width: 500px;">Item Description</th> 
                            <th style="width: 20px;">Quantity/Unit</th>
                            <th style="width: 20px;">ABC</th>
                            <th style="width: 20px;">Bid Price</th>
                            <th style="width: 20px;">Total Bid Price</th>
                            <th style="width: 500px;">Technical Proposal / Offer</th>
                            <th style="width: 100px;">Delivery Term</th>
                           
                            <th v-if="purchase_request.status_id == 4">Recommend Bid For Award?</th>
                            </tr>
                        </thead>
                     
                        <tbody>
                            <tr v-for="(bid_item, bidItemIndex) in bid.bid_items" :key="bid_item.bid_item_id"  >
                            <td>{{ bidItemIndex + 1 }}</td>
                            <td>   
                                <b-badge 
                                v-if="bid_item.status"
                                :variant="getBadgeVariant(bid_item.status.name)" 
                                style="color: white;">
                                {{ bid_item.status.name }} 
                                <i v-if="bid_item.status.name == 'Not Available for Award'" class="ri-close-line"></i>
                                <i v-if="bid_item.status.name == 'Available for Award'" class="ri-check-line"></i>
                                <i v-if="bid_item.status.name == 'Awarded'" class="ri-check-line"></i>
                                </b-badge>  
                            </td>
                            <td  style="text-align:left;width: break-word; word-break: break-word; white-space: normal;">
                                <span v-html="bid_item.item_description"></span>
                            </td>
                          <td>
                                {{ bid_item.item_quantity }}
                                {{ bid_item.item_quantity > 1 ? bid_item.item_unit_type.name_long : bid_item.item_unit_type.name_short }}
                            </td>
                            <td>
                                {{ formatCurrency(bid_item.total_cost) }}
                            </td>
                            <td @click="openEditItemBidOffer(bid_item)">
                                <span v-if="bid_item.item_bid_price > 0">
                                   <u> {{ formatCurrency(bid_item.item_bid_price) }}</u>
                                </span>
                                <span v-if="bid_item.item_bid_price == 0">
                                    <b><i class="text-primary"><u>free</u></i></b>
                                </span>
                                <span v-if="bid_item.item_bid_price == null">
                                    <b><i class="text-primary"><u>not set</u></i></b>
                                </span>
                            </td>
                          
                            <td>
                                <span v-if="bid_item.item_bid_price > 0">
                                    {{ formatCurrency(bid_item.item_quantity * bid_item.item_bid_price) }}
                                </span>
                                <span v-else>
                                    <b><i class="text-primary">not set</i></b>
                                </span>
                            </td>
                            <td  style="text-align:left;width: break-word; word-break: break-word; white-space: normal;">  
                                <div v-html="bid_item.technical_proposal"></div>
                            </td>
                            <td>{{ bid_item.delivery_term }}</td>
                            

                            <td v-if=" purchase_request.status_id == 4">
                                <span  class="d-flex justify-content-center">
                                    <b-form-checkbox
                                        v-model="bid_item.is_checked"
                                        name="checkbox"
                                        class="border-primary bg-primary"
                                        :value="true"
                                        :disabled="isOtherSupplierChecked(bidItemIndex, bid) || bid_item.item_bid_price ==  null "
                                        @change="handleCheckboxChange(bidItemIndex , bid)"
                                    >
                                    </b-form-checkbox>
                                </span>
                            </td>

                            </tr>
                        </tbody>
                    </table>
                   
                    <Pagination class="ms-2 me-2" v-if="meta" @fetch="fetch" :lists="lists.length" :links="links" :pagination="meta" />
                    </div>   
                </div>
            </div>
        </b-tab>

        <b-row>
            <b-col>
                <div class="d-flex justify-content-start">
                <b-button type="button" variant="primary" style=" background: grey; color: white"@click="goBackPage()">
                    <i class="ri-arrow-left-line align-bottom me-1"></i> Back
                </b-button>
            </div>
            </b-col>
            <b-col v-if="purchase_request?.status_id == 4">
                 <div class="d-flex justify-content-end">
                    <b-button @click="openConfirmation()"  variant="primary"  block>Save Bids For Award</b-button>
                </div>
            </b-col>
        </b-row>
       
       
        </b-tabs>
      
    </div>

 

    <Create :dropdowns="dropdowns" :bid_items="bid_items" ref="createBids"/>
    <EditItemModal  ref="editItem"/>
    <Confirmation :bids="bids" :purchase_request="purchase_request" ref="confirmation"/>
    <!-- <GenerateBACResoModal  :bids="dropdowns.bids" :data="purchase_request" ref="BACReso"/> -->
    <CreatePOModal :dropdowns="dropdowns"  :data="form" ref="createPO"/>
      
</template>
<script>
import _ from 'lodash';
import PageHeader from '@/Shared/Components/PageHeader.vue';
import { useForm } from '@inertiajs/vue3';
import Multiselect from "@vueform/multiselect";
import InputError from '@/Shared/Components/Forms/InputError.vue';
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
import TextInput from '@/Shared/Components/Forms/TextInput.vue';
import Checkbox from '@/Shared/Components/Forms/Checkbox.vue';
import Create from '../../Modals/CreateBids.vue';
import GenerateBACResoModal from '@/Pages/Modules/FAIMS/Procurement/Purchase-Request/Modals/GenerateBACResolution.vue';
import Confirmation from '@/Pages/Modules/FAIMS/Procurement/Purchase-Request/Modals/Confirmation.vue';
import EditItemModal from '@/Pages/Modules/FAIMS/Procurement/Purchase-Request/Modals/EditItem.vue';
import CreatePOModal from '@/Pages/Modules/FAIMS/Procurement/Purchase-Request/Modals/CreatePO.vue';

export default {
    components: {
        // ,Create, 
        EditItemModal , Confirmation, GenerateBACResoModal, CreatePOModal, PageHeader, InputError, InputLabel, TextInput, Multiselect, Checkbox },
    props: ['purchase_request','dropdowns', 'lists' , 'bids', 'option'],
    data(){
        return {
            currentUrl: window.location.origin,
            lists: [],
            meta: {},
            links: {},
            filter: {
                keyword: null,
            },
            index: null,
            is_checked: false,
            checkedItems: [],
            //not_checked_items: [],
            recommendedBidsForAward: {},
        }
    },

    methods: { 

        openAddBids(){
            this.$refs.createBids.show();
        },

        openConfirmation(){
            this.$refs.confirmation.edit(this.checkedItems );
         
        },

        createPO(){
            this.$refs.createPO.show();
        },

        setBidPrice(data , type){
            this.$refs.createBids.edit(data , type);
           
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
                case 'Not Available for Award/Re-award':
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

        handleCheckboxChange(itemIndex, currentBid) {
            // If checked → store supplier name
            if (currentBid.bid_items[itemIndex].is_checked) {
                this.checkedItems[itemIndex] = currentBid;
            } else {
                this.not_checked_items[itemIndex] = currentBid;
                delete this.checkedItems[itemIndex];
            }
        },

        isOtherSupplierChecked(itemIndex, currentItem) {
            return (
                this.checkedItems[itemIndex] &&
                this.checkedItems[itemIndex] !== currentItem
            );
        },

        //count how how many items checked in a supplier
        getCheckedBidsCount(bid_items) {
            return bid_items.filter(bid_item => bid_item.is_checked).length;
        },

        getTotalBidPrice() {
            this.form.total_bid_price = this.form.item_bid_price * this.form.item_quantity;
            return  this.form.total_bid_price;
        },

        openEditItemBidOffer(bid_item ){
            if(this.purchase_request.status_id == 4){
                this.$refs.editItem.edit(bid_item );
            }

        },
        openBACReso(){
            if(this.purchase_request.status_id == 7){
                this.$refs.BACReso.show();
            }

        },

        printBids(data){
           window.open('/faims/bids/print/'+data.id+'?pr_id='+ data.id +'&purchase_request_number='+data.purchase_request_number );
        },

        // printPurchaseOrder(data){
        //    window.open('/faims/po/print/'+data.id+'?pr_id='+ data.id +'&purchase_request_number='+data.purchase_request_number );
        // },

    }
}
</script>

<style>
.horizontal-scroll-tabs .nav-tabs .nav-link {
    background-color: white !important;
    color: black !important; /* Ensure text is visible */
    border-bottom: 5px lightgrey solid;
    border-top: 5px lightgrey solid;
    width: 200px;
}

/* Change background when tab is active */
.horizontal-scroll-tabs .nav-tabs .nav-link.active {
    border-bottom: 5px darkblue solid;
    border-top: 5px darkblue solid;
    font-weight: bolder;
    color: darkblue !important;
}
</style>

<style scoped>

td, th{
   border:1px solid;
   padding: 5px ;
   vertical-align: top;
   text-align: center;
}



</style>