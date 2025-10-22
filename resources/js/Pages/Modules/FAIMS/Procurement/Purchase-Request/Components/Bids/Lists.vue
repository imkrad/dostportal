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
                {{ purchase_request.purchase_request_number }}
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
            <b-dropdown-item @click="printBids(purchase_request)">
                <i class="ri-printer-line align-bottom me-1"></i> 
                Print
            </b-dropdown-item>
            <b-dropdown-item @click="openBACReso()" v-if="purchase_request.status_id == 7">
                <i class="ri-file-line align-bottom me-1"></i> 
                BAC Resolution
            </b-dropdown-item>
            <b-dropdown-item @click="openNoticeOfAward()"  v-if="purchase_request.status_id == 8" >
                <i class="ri-file-line align-bottom me-1"></i> 
                Notice of Award(NOA)
            </b-dropdown-item>
            <b-dropdown-item @click="createPO(purchase_request)" v-if="purchase_request.status_id == 8">
                <i class="ri-printer-line align-bottom me-1"></i> 
                Create Purchase Order
            </b-dropdown-item>
          
            </b-dropdown>
        </b-col>
        </b-row>
    </div>

 

    <Create :dropdowns="dropdowns" :items="dropdowns.item_details" ref="createBids"/>
    <EditItemModal   @update-description="updateItemDescription" @update-price="updateItemBidPrice" ref="editItem"/>
    <Confirmation  :data="dropdowns.lists.data" ref="confirmation"/>
    <GenerateBACResoModal  :bids="dropdowns.bids" :data="purchase_request" ref="BACReso"/>
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
    props: ['purchase_request','dropdowns', 'lists' , 'option'],
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
            if(this.purchase_request.status_id == 5){
                this.$refs.editItem.edit(item, index , "edit_description");
            } 
        },

        openEditItemBidPrice(item , index){
            if(this.purchase_request.status_id == 5){
                this.$refs.editItem.edit(item , index , "edit_bid_price");
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