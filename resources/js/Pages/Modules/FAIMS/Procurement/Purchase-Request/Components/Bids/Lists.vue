<template>
    <PageHeader v-if="option == 'bids'" title="Abstract of Bids" pageTitle="Bids" />
    <div>
         <b-row class="align-items-center">
        <!-- Left Content -->
        <b-col>
            <th class="font-weight-bold;" style="border:none" >
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
            <b-dropdown-item @click="openBACReso()" v-if="dropdowns.data.status_id == 7">
                <i class="ri-file-line align-bottom me-1"></i> 
                BAC Resolution
            </b-dropdown-item>
            <b-dropdown-item @click="openNoticeOfAward()"  v-if="dropdowns.data.status_id == 8" >
                <i class="ri-file-line align-bottom me-1"></i> 
                Notice of Award(NOA)
            </b-dropdown-item>
            <b-dropdown-item @click="createPO(dropdowns.data)" v-if="dropdowns.data.status_id == 8">
                <i class="ri-printer-line align-bottom me-1"></i> 
                Create Purchase Order
            </b-dropdown-item>
          
            </b-dropdown>
        </b-col>
        </b-row>
    </div>

    <div class="horizontal-scroll-tabs">
        <b-tabs class="bg-white " card>
        <b-tab v-for="(item, index) in dropdowns.lists.data" :key="index">
            <template #title>
                {{ item.supplier.name }}
                <b-badge variant="primary" v-if="getCheckedBidsCount(item) > 0">
                    {{ getCheckedBidsCount(item) }}
                </b-badge>
            </template>
            <div>
                
                <div class="file-manager-content w-100 pt-2 pb-0" style="height: calc(80vh - 180px); overflow: auto;" ref="box">
                    <div>
                    <table style="width:100%; border-collapse: collapse; border: 1px solid">
                        <thead>
                            <tr>
                            <th>#</th>
                            <th style="width: 20px;">Status</th>
                            <th style="width: 500px;">Item Description</th> 
                            <th style="width: 20px;">Quantity/Unit</th>
                            <th style="width: 20px;">ABC</th>
                            <th style="width: 20px;">Bid Price</th>
                            <th style="width: 20px;">Total Bid Price</th>
                            <th>Remarks</th> 
                            <th v-if="dropdowns.data.status_id != 7">Recommend Bids For Award?</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr v-for="(bid, bidIndex) in dropdowns.lists.data[index].bids_details" :key="index" >
                            <td>{{ bidIndex + 1 }}</td>
                            <td>   
                                <b-badge 
                                v-if="bid.status"
                                :variant="getBadgeVariant(bid.status.name)" 
                                style="color: white;">
                                {{ bid.status.name }} 
                                <i v-if="bid.status.name == 'Pending for Award'" class="ri-close-line"></i>
                                <i v-if="bid.status.name == 'Not Available for Award'" class="ri-close-line"></i>
                                <i v-if="bid.status.name == 'Available for Award'" class="ri-check-line"></i>
                                <i v-if="bid.status.name == 'Awarded'" class="ri-check-line"></i>
                                </b-badge>  
                            </td>
                            <td @click="openEditItemDescription(bid , index)"  style="text-align:left;width: break-word; word-break: break-word; white-space: normal;">
                                <span v-html="bid.bids_description"></span>
                            </td>
                            <td >
                                {{ bid.bids_quantity }} {{ bid.unit_type.name_long }} 
                            </td>
                            <td>
                                {{ formatCurrency(bid.bids_abc) }}
                            </td>
                            <td @click="openEditItemBidPrice(bid, index)">
                                <span v-if="bid.bids_price > 0">
                                   <u> {{ formatCurrency(bid.bids_price) }}</u>
                                </span>
                                <span v-else>
                                    <b><i class="text-primary"><u>not set</u></i></b>
                                </span>
                            </td>
                            <td>
                                <span v-if="bid.bids_price > 0">
                                    {{ formatCurrency(bid.bids_quantity * bid.bids_price) }}
                                </span>
                                <span v-else>
                                    <b><i class="text-primary">not set</i></b>
                                </span>
                            </td>
                            
                            <td @click="openEditItemBidPrice(bid, index)">
                                <span v-if="bid.bids_price > 0">
                                    {{ bid.remarks }}
                                </span>
                                <span v-else>
                                    <b><i class="text-primary">not set</i></b>
                                </span>
                            </td>

                            <td v-if="dropdowns.data.status_id != 7">
                                <span  class="d-flex justify-content-center">
                                    <b-form-checkbox
                                        v-model="bid.is_checked"
                                        name="checkbox"
                                        class="border-primary bg-primary"
                                        :value="true"
                                        :disabled="isOtherSupplierChecked(bidIndex, item) || bid.bids_price ==  0"
                                        @change="handleCheckboxChange(bidIndex, item )"
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
            <b-col v-if="dropdowns.data.status_id == 5">
                 <div class="d-flex justify-content-end">
                    <b-button @click="openConfirmation()" :data="checkedItems"  variant="primary"  block>Save Bids For Award</b-button>
                </div>
            </b-col>
        </b-row>
       
       
        </b-tabs>
      
    </div>

    <Create :dropdowns="dropdowns" :items="dropdowns.item_details" ref="createBids"/>
    <EditItemModal   @update-description="updateItemDescription" @update-price="updateItemBidPrice" ref="editItem"/>
    <Confirmation  :data="dropdowns.lists.data" ref="confirmation"/>
    <GenerateBACResoModal  :bids="dropdowns.bids" :data="dropdowns.data" ref="BACReso"/>
    <CreatePOModal :dropdowns="dropdowns"  :data="form" ref="createPO"/>
      
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
import GenerateBACResoModal from '@/Pages/Modules/FAIMS/Procurement/Purchase-Request/Modals/GenerateBACResolution.vue';
import Confirmation from '@/Pages/Modules/FAIMS/Procurement/Purchase-Request/Modals/Confirmation.vue';
import EditItemModal from '@/Pages/Modules/FAIMS/Procurement/Purchase-Request/Modals/EditItem.vue';
import CreatePOModal from '@/Pages/Modules/FAIMS/Procurement/Purchase-Request/Modals/CreatePO.vue';
import { router } from '@inertiajs/vue3';

export default {
    components: {EditItemModal, Confirmation,Create,  GenerateBACResoModal, CreatePOModal, PageHeader, InputError, InputLabel, TextInput, Multiselect, Checkbox },
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
            index: null,
            is_checked: false,
            checkedItems: {},
            recommendedBidsForAward: {},
        }
    },

    methods: { 

        openAddBids(){
            this.$refs.createBids.show();
        },

        openConfirmation(){
            this.$refs.confirmation.show();
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
                case 'Not Available for Award':
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

       // Handle checkbox state when one is checked
       handleCheckboxChange(bidIndex, currentItem) {
            //If the current checkbox is checked, store the supplier that checked it
            if (currentItem.bids_details[bidIndex].is_checked) {
                this.checkedItems[bidIndex] = currentItem.supplier.name;
            } else {
                delete this.checkedItems[bidIndex]; // Remove tracking if unchecked
            }
        },

        // Check if the same `bidIndex` is checked by another supplier
        isOtherSupplierChecked(bidIndex, currentItem) {
            return (
                this.checkedItems[bidIndex] && 
                this.checkedItems[bidIndex] !== currentItem.supplier.name
            );
        },
        //count how how many items checked in a supplier
        getCheckedBidsCount(item) {
            return item.bids_details.filter(bid => bid.is_checked).length;
        },

        getTotalBidPrice() {
            this.form.total_bid_price = this.form.item_bid_price * this.form.item_quantity;
            return  this.form.total_bid_price;
        },

        openEditItemDescription(item , index){
            if(this.dropdowns.data.status_id == 5){
                this.$refs.editItem.edit(item, index , "edit_description");
            } 
        },

        openEditItemBidPrice(item , index){
            if(this.dropdowns.data.status_id == 5){
                this.$refs.editItem.edit(item , index , "edit_bid_price");
            }

        },

        openBACReso(){
            if(this.dropdowns.data.status_id == 7){
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