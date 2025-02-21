<template>
    <b-modal v-model="showModal" header-class="p-3" title="Create Bids" size="xl" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop >
        <form class="customform">
            <BRow>
                <BCol lg="6" class="mt-2">
                    <InputLabel for="supplier" value="Supplier"/>
                    <Multiselect 
                    :options=" dropdowns.suppliers " 
                    v-model="form.supplier_id"
                    :searchable="true" label="name"
                    placeholder="Select Supplier"/>
                </BCol>
                <BCol lg="6" class="mt-2">
                    <InputLabel value="Purchase Request No."/>
                    <TextInput v-model="form.pr_no"  type="text" class="form-control"  :light="true" readonly/>
                </BCol>

                <!-- {{  form.items  }} -->

                <div v-if="form.supplier_id" class="file-manager-content w-100 p-4 pb-0" style="height: calc(90vh - 180px); overflow: auto;" ref="box">
                    <div>
                    <table class="table  mb-0">
                        <thead class="table-light">
                            <tr class="fs-11">
                                <th>Remarks</th>    
                                <th>Item Description</th> 
                                <th></th>
                                <th>Quantity/Unit</th>
                                <th>ABC</th>
                                <th>Bid Price</th>
                                <th>Total Bid Price</th>
                                <th>Actions</th>
                                <th>
                                    <b-form-checkbox
                                            id="checkbox-1"
                                            v-model="status"
                                            name="checkbox-1"
                                                value="awarded"
                                                >
                                        </b-form-checkbox>
                                    </th>
                                </tr>
                            </thead>
                        

                            <template v-if="form.type == 'for_all_items'">
                                <tbody>
                                    <tr v-for="(item, index) in form.items" :key="index" style="vertical-align: center;">
                                        <!-- Status Badge -->
                                        <td>
                                            <b-badge 
                                                v-if="item.status"
                                                :variant="getBadgeVariant(item.status.name)" 
                                                style="color: white;">
                                                {{ item.status.name }}
                                                <i v-if="item.status.name == 'Pending'" class="ri-close-line"></i>
                                                <i v-if="item.status.name == 'For Bids'" class="ri-wallet-line"></i>
                                                <i v-if="item.status.name == 'Awarded'" class="ri-check-line"></i>
                                            </b-badge>  
                                        </td>
                                        <!-- Item Description -->
                                        <td>
                                            <div v-html="item.description"></div>   
                                        </td>
                                        <td>
                                            
                                        </td>
              
                                        <!-- Quantity and Unit -->
                                        <td>{{ item.quantity }} {{ item.item_unit }}</td>
                                        <!-- Total Cost -->
                                        <td>{{ formatCurrency(item.total_cost) }}</td>
                                        <!-- Conditional TextInput -->
                                        <td>
                                           <span v-if="item.item_bid_price && item.is_checked == true">
                                            {{ formatCurrency(item.item_bid_price) }}
                                           </span>
                                            <span v-else class="text-info"> 
                                                not set
                                            </span>
                                        </td>
                                        <!-- Calculated Bid Price -->
                                        <td>
                                            <span v-if="item.item_bid_price > 0 && item.is_checked == true">
                                                {{ formatCurrency(item.item_bid_price * item.quantity) }}
                                            </span>
                                            <span v-else class="text-info">
                                                not set
                                            </span>
                                        </td>
                                        <td>
                                            <b-dropdown size="sm" variant="success" v-if="item.is_checked == true">
                                            <template #button-content>
                                                <b>Actions</b>
                                            </template>
                                            <b-dropdown-item @click="openEditItemDescription(item)">
                                                <i class="ri-check-line align-bottom me-1"></i> 
                                                Edit Item Description
                                            </b-dropdown-item>       
                                            <b-dropdown-item @click="openEditItemBidPrice(item)">
                                                <i class="ri-check-line align-bottom me-1"></i> 
                                                Set Item Bid Price
                                            </b-dropdown-item>                                     
                                        
                                            </b-dropdown>
                                        </td>
                                        <!-- Checkbox -->
                                        <td>
                                            <b-form-checkbox
                                                v-model="item.is_checked"
                                                name="checkbox"
                                                :value="true"
                                                :unchecked-value="false"
                                            >
                                            </b-form-checkbox>
                                        </td>
                                        
                                    </tr>
                                </tbody>
                            </template>
                    </table>
                    <Pagination class="ms-2 me-2" v-if="meta" @fetch="fetch" :lists="lists.length" :links="links" :pagination="meta" />
                    </div>              
                </div>
                <BCol lg="12"><hr class="text-muted mt-4 mb-0"/></BCol>
                </BRow>
            </form>

    
            <template v-slot:footer>
                <b-button @click="hide()" variant="danger" block>Close</b-button>
                <b-button @click="saveBids(form)" variant="primary"  block>Save Bids</b-button>
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
                supplier_id: null,
                is_checked : null,
                type: null
            }),
            action_type: null,
            currentUrl: window.location.origin,        
            showModal: false,
            updatedDescription: [],
            itemsEdited: [],
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
            this.selectedItem = item;
            this.$refs.editItem.edit(item , "edit_bid_price");

        },

        saveBids(data){
            router.post('/faims/bids', { data, option: 'save_bids' });
          
            this.form.reset(); 
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
            console.log(updatedItem,333);
            console.log(this.form.items,444);
            // Find the item in the list and update its description
            const item = this.form.items.find(i => i.value === updatedItem.id);
            if (item) {
                item.item_bid_price = updatedItem.item_bid_price;
            }
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