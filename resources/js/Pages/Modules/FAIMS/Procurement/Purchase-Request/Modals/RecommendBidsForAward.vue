<template>
    <b-modal 
    v-model="showModal" 
    header-class="p-3" 
    title="Recommend Bids For Award" 
    class="v-modal-custom" 
    size="xl"
    modal-class="zoomIn" 
    centered 
    no-close-on-backdrop >
        <form class="customform">
            <BRow>

                <!-- {{  form.items  }} --> 

                <div class="file-manager-content w-100 p-4 pb-0" style="height: calc(90vh - 180px); overflow: auto;" ref="box">
                    <div>
                    <table class="table  mb-0">
                        <thead class="table-light">
                            <tr class="fs-11">
                                <th>Supplier</th>  
                                <th>Item Description</th> 
                                <th></th>
                                <th>Quantity/Unit</th>
                                <th>ABC</th>
                                <th>Bid Price</th>
                                <th>Total Bid Price</th>
                                <th>Award?</th>
                                  
                                </tr>
                            </thead>
                        
                            <tbody>
                                <template v-for="(item, index) in items" :key="index">
                                    <!-- Supplier Row -->
                                    <tr style="vertical-align: middle;" @click="toggleBids(index)">
                                        <td colspan="8" class="bg-primary text-white">
                                            {{ item.supplier.name }}
                                        </td> 
                                    </tr>

                                    <!-- Bids Rows (Collapsed/Expanded) -->
                                    <tr v-for="(bid, bidIndex) in item.bids_details" :key="bidIndex" v-show="item.showBids">
                                        <td></td>
                                        <td colspan="2">
                                            <div v-html="bid.bids_description"></div>   
                                        </td>
                                        <td>
                                            {{ bid.bids_quantity }} {{ bid.unit_type.name_long }}
                                        </td>
                                        <td>
                                            {{ formatCurrency(bid.bids_abc) }}
                                        </td>
                                        <td>
                                            {{ formatCurrency(bid.bids_price) }}
                                        </td>
                                        <td>
                                            {{ formatCurrency(bid.bids_price * bid.bids_quantity)  }}
                                        </td>
                                        <td>
                                            <b-form-checkbox
                                                v-model="bid.is_checked"
                                                name="checkbox"
                                                :value="true"
                                                :disabled="isOtherSupplierChecked(bidIndex, item)"
                                                @change="handleCheckboxChange(bidIndex, item)"
                                            >
                                            </b-form-checkbox>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>     
                    </table>
                    <Pagination class="ms-2 me-2" v-if="meta" @fetch="fetch" :lists="lists.length" :links="links" :pagination="meta" />
                    </div>              
                </div>
                <BCol lg="12"><hr class="text-muted mt-4 mb-0"/></BCol>
                </BRow>
            </form>

    
            <template v-slot:footer>
                <b-button @click="hide()" variant="danger" block>Close</b-button>
                <b-button @click="saveAward()" variant="primary"  block>Award</b-button>
            </template>
      <EditItemModal   @update-description="updateItemDescription" @update-price="updateItemBidPrice" ref="editItem"/>

    </b-modal>
</template>
<script>
import { useForm } from '@inertiajs/vue3';
import Multiselect from "@vueform/multiselect";
import InputError from '@/Shared/Components/Forms/InputError.vue';
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
import TextInput from '@/Shared/Components/Forms/TextInput.vue';
import { router } from '@inertiajs/vue3';
import EditItemModal from './EditItem.vue';

export default {
    components: { InputError, InputLabel, TextInput, Multiselect, EditItemModal  },
    props:['dropdowns', 'items'],
    data(){
        return {
            currentUrl: window.location.origin,
            form: useForm({
                id: null,
                supplier_id: null,
                pr_id: null,
                pr_no: null,
                items: {},
                is_checked : null,
                type: null
            }),
            action_type: null,
            currentUrl: window.location.origin,        
            showModal: false,
            updatedDescription: [],
            itemsEdited: [],
            checkedItems: {},// Object to track checked `bidIndex`
            showBids:false,
        }
    },

    watch: {
        'form.item_bid_price': function(value) {
            if(value){
                this.getTotalBidPrice();
            }
        }
    },

    methods: { 


        show(){
            // this.form.reset();
            this.showModal = true;
        },

        edit(data , type){
            this.form.type = type;
            this.form.pr_id = data.id;
            this.form.pr_no = data.purchase_request_number;
            this.form.items = this.items;
            this.showModal = true;
        },
      
        hide(){
            this.showModal = false;
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

        getTotalBidPrice() {
            console.log(this.form, 88);
            // if (!bidPrice || !quantity) return 0; // Handle missing or invalid values
            this.form.total_bid_price = this.form.item_bid_price * this.form.item_quantity;
            return  this.form.total_bid_price;
        },

        openEditItemDescription(item){
            this.selectedItem = item;
            this.$refs.editItem.edit(item , "edit_description");

        },

        openEditItemBidPrice(item){
            console.log(item, 222);
            this.selectedItem = item;
            this.$refs.editItem.edit(item , "edit_bid_price");

        },

        saveAward(){
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

        updateItemDescription(updatedItem){
            // Find the item in the list and update its description
            const item = this.form.items.find(i => i.value === updatedItem.id);
            if (item) {
                item.description = updatedItem.description;
            }
        },
        updateItemBidPrice(updatedItem){
            // Find the item in the list and update its description
            const item = this.form.items.find(i => i.value === updatedItem.id);
            if (item) {
                item.item_bid_price = updatedItem.item_bid_price;
            }
        },
        
        formatCurrency(value) {
            return new Intl.NumberFormat('en-PH', {
            style: 'currency',
            currency: 'PHP',
            }).format(value);
        },


       // Handle checkbox state when one is checked
        handleCheckboxChange(bidIndex, currentItem) {
            // If the current checkbox is checked, store the supplier that checked it
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

        toggleBids(index) {
            // Toggle the visibility of bids for the clicked supplier
            this.items[index].showBids = !this.items[index].showBids;
        }
        
    }
}
</script>

<style scoped>
/* Custom styles for the popover */
.custom-popover {
  width: 100% !important; /* Full width */
  max-width: 100% !important; /* Remove default max-width */
}
</style>
