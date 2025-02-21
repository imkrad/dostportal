<template>
    <PageHeader v-if="option == 'bids'" title="Abstract of Bids" pageTitle="Bids" />
    <div>
        <b-row class="">
        <b-row class="g-2 mb-3 mt-n2">
            <b-col lg>
                <div class="input-group mb-1">
                    <span class="input-group-text"> <i class="ri-search-line search-icon"></i></span>
                    <input type="text" v-model="filter.keyword" placeholder="Search Bids" class="form-control" style="width: 60%;">
                    <span @click="refresh()" class="input-group-text" v-b-tooltip.hover title="Refresh" style="cursor: pointer;"> 
                        <i class="bx bx-refresh search-icon"></i>
                    </span>
                    <b-button type="button" variant="primary" @click="setBidPrice(dropdowns.data,'for_all_items')">
                        <i class="ri-add-circle-fill align-bottom me-1"></i> New
                    </b-button>
                    
                </div>
            </b-col>
          
        </b-row>
      
         </b-row>
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
            <!-- <b-dropdown-item @click="printBids(dropdowns.data)">
                <i class="ri-check-line align-bottom me-1"></i> 
                Award
            </b-dropdown-item> -->
            <b-dropdown-item  @click="openRecommendBidsForAward()" v-if="dropdowns.data.status_id == 5">
                <i class="ri-file-line align-bottom me-1"></i> 
                Recommend Bids for Award
            </b-dropdown-item>
            <b-dropdown-item @click="printBACReso(dropdowns.data)" v-if="dropdowns.data.status_id == 7">
                <i class="ri-file-line align-bottom me-1"></i> 
                Generate BAC Resolution
            </b-dropdown-item>
            <b-dropdown-item @click="openNoticeOfAward()"  v-if="dropdowns.data.status_id == 7" >
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
        <b-tabs class="bg-white" card>
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
                            <th>For BAC Resolution?</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr v-for="(bid, bidIndex) in dropdowns.lists.data[index].bids_details" :key="index" >
                            <td v-if="bid.bids_price">{{ bidIndex + 1 }}</td>
                            <td v-if="bid.bids_price">   
                                <b-badge 
                                v-if="bid.status"
                                :variant="getBadgeVariant(bid.status.name)" 
                                style="color: white;">
                                {{ bid.status.name }} 
                                <i v-if="bid.status.name == 'Pending for Award'" class="ri-close-line"></i>
                                <i v-if="bid.status.name == 'Not Available for Award'" class="ri-wallet-line"></i>
                                <i v-if="bid.status.name == 'Available for Award'" class="ri-check-line"></i>
                                <i v-if="bid.status.name == 'Awarded'" class="ri-check-line"></i>
                                </b-badge>  
                            </td>
                            <td @click="openEditItemDescription(bid , index)" v-if="bid.bids_price"  style="text-align:left;width: break-word; word-break: break-word; white-space: normal;">
                                <span v-html="bid.bids_description"></span>
                            </td>
                            <td v-if="bid.bids_price">
                                {{ bid.bids_quantity }} {{ bid.unit_type.name_long }} 
                            </td>
                            <td v-if="bid.bids_price">
                                {{ formatCurrency(bid.bids_abc) }}
                            </td>
                            <td @click="openEditItemBidPrice(bid, index)">
                                <span v-if="bid.bids_price > 0">
                                    {{ formatCurrency(bid.bids_price) }}
                                </span>
                                <span v-else>
                                    <b><i class="text-primary"><u>not set</u></i></b>
                                </span>
                            </td>
                            <td v-if="bid.bids_price">
                                {{ formatCurrency(bid.bids_quantity * bid.bids_price) }}
                            </td>
                            
                            <td v-if="bid.bids_price">
                                {{ bid.remarks }}
                            </td>

                            <td>
                                <span  class="d-flex justify-content-center">
                                    <b-form-checkbox
                                        v-model="bid.is_checked"
                                        name="checkbox"
                                        :value="true"
                                        :disabled="isOtherSupplierChecked(bidIndex, item)"
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
        <div class="d-flex justify-content-end">
            <b-button @click="openConfirmation()" variant="primary"  block>Save For BAC Resolution</b-button>
        </div>
        </b-tabs>
      
    </div>

    

    <Create :dropdowns="dropdowns" :items="dropdowns.item_details" ref="createBids"/>
    <Confirmation :type="forBACResolution" ref="confirmation"/>
    <GenerateBACResoModal  :data="form" ref="createBACReso"/>
    <CreatePOModal :dropdowns="dropdowns"   :data="form" ref="createPO"/>
    <EditItemModal   @update-description="updateItemDescription" @update-price="updateItemBidPrice" ref="editItem"/>
    
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
        }
    },

    // created(){
    //     this.fetch();
    // },


    methods: { 

        openAddBids(){
            this.$refs.createBids.show();
        },

        openConfirmation(){
            this.$refs.confirmation.show();
        },

        createBACReso(){
            this.$refs.createBACReso.show();
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

        printBids(data){
           window.open('/faims/bids/print/'+data.id+'?pr_id='+ data.id +'&purchase_request_number='+data.purchase_request_number );
        },


        openRecommendBidsForAward(){
            this.$refs.recommendBidsForAward.show();
        },

        // printPurchaseOrder(data){
        //    window.open('/faims/po/print/'+data.id+'?pr_id='+ data.id +'&purchase_request_number='+data.purchase_request_number );
        // },


        printBACReso(data){
          window.open('/faims/BACReso/print/'+data.id+'?pr_id='+ data.id +'&purchase_request_number='+data.purchase_request_number );
        },


        updateRecommendedBids(item) {
            console.log(item.supplier, 99);
            if (item.is_checked) {
                this.recommended_bids[item.id] = { 
                    bid_id: item.id,
                    supplier_id: item.supplier,
                    bid_price: item.bids_price,
                    total_price: item.bids_quantity * item.bids_price,
                };
            } else {
                delete this.recommended_bids[item.id]; // Remove unchecked items
            }
            console.log(this.recommended_bids, 99);
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
            console.log(this.form, 88);
            // if (!bidPrice || !quantity) return 0; // Handle missing or invalid values
            this.form.total_bid_price = this.form.item_bid_price * this.form.item_quantity;
            return  this.form.total_bid_price;
        },

        openEditItemDescription(item , index){
            this.$refs.editItem.edit(item, index , "edit_description");

        },

        openEditItemBidPrice(item , index){
            this.$refs.editItem.edit(item , index , "edit_bid_price");

        },
        updateItemDescription(updatedItem) {
            // Find the item in the list
            const item = this.dropdowns.lists.data[updatedItem.index].bids_details.find(i => i.id === updatedItem.id);
            if (item) {
                item.bids_description = updatedItem.description;
            }
        },

        updateItemBidPrice(updatedItem){
            // Find the item in the list and update its description
            const item = this.dropdowns.lists.data[updatedItem.index].bids_details.find(i => i.id === updatedItem.id);
            if (item) {
                item.bids_price = updatedItem.item_bid_price;
            }
        },

        saveForBACResolution(){
            // Gather all checked bids
            const bidsForAward = [];
            const bidsNotForAward = [];

            this.items.forEach(item => {
                item.bids_details.forEach(bid => {
                    if (bid.is_checked) {
                        bidsForAward.push({
                            id:bid.id,
                            purchase_request_id: item.purchase_request.id,
                            supplier_id: item.supplier.id,
                            supplier: item.supplier.name,
                            bid_description: bid.bids_description,
                            quantity: bid.bids_quantity,
                            unit: bid.unit_type.name_long,
                            abc: bid.bids_abc,
                            price: bid.bids_price,
                            total_price: bid.bids_price * bid.bids_quantity
                        });
                    }
                    else{
                        bidsNotForAward.push({
                            id:bid.id,
                            purchase_request_id: item.purchase_request.id,
                            supplier_id: item.supplier.id,
                            supplier: item.supplier.name,
                            bid_description: bid.bids_description,
                            quantity: bid.bids_quantity,
                            unit: bid.unit_type.name_long,
                            abc: bid.bids_abc,
                            price: bid.bids_price,
                            total_price: bid.bids_price * bid.bids_quantity
                        });
                    }
                });
            });

            router.post('/faims/bids', {  items: bidsForAward, itemsNotAvailableForAward: bidsNotForAward, option: 'save_award' });
            this.hide();
        },

    }
}
</script>

<style scoped>

td, th{
   border:1px solid;
   padding: 5px ;
   vertical-align: top;
   text-align: center;
}

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