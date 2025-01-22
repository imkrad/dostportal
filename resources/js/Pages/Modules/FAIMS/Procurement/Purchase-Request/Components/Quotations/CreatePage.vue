<template>
    <PageHeader v-if="option == 'quotations'" title="Request For Quotation" pageTitle="Quotation" />
    <div class="chat-wrapper d-lg-flex gap-1 mx-n4 mt-n4 p-1">
        <div class="file-manager-content w-100 p-4 pb-0" style="height: calc(100vh - 180px); overflow: auto;" ref="box">
            <form class="customform">
                <BRow>
                    <BCol lg="12" class="mt-2">
                    <div>
                        <b-card  class="bg-light">             
                            <BRow>
                                <BCol lg="6" class="mt-2">
                                    <InputLabel for="supplier" value="Supplier" :message="form.errors.supplier_id"/>
                                    <Multiselect 
                                    :options="dropdowns.suppliers" 
                                    v-model="form.supplier_id"
                                    :searchable="true" label="name"
                                    placeholder="Select Supplier"/>
                                </BCol>

                                <BCol lg="6" class="mt-2">
                                    <InputLabel value="PR Number" :message="form.errors.purchase_request_date"/>
                                    <TextInput v-model="form.purchase_request_number" type="text" class="form-control"  :light="true" readonly/>
                                </BCol>

                                <BCol lg="6" class="mt-2">
                                    <InputLabel for="address" value="Address" :message="form.errors.address"/>
                                    <b-form-textarea
                                        id="textarea"
                                        v-model="form.address"
                                        placeholder="Enter Address"
                                        rows="2"
                                        max-rows="10">
                                    </b-form-textarea>
                                </BCol>

                                <BCol lg="6" class="mt-2">
                                    <InputLabel value="Date" :message="form.errors.purchase_request_date"/>
                                    <TextInput v-model="form.purchase_request_date" type="text" class="form-control"  :light="true" readonly/>
                                </BCol>

                                <BCol lg="6" class="mt-2">
                                    <InputLabel value="Submissions not Later than " :message="form.errors.submission_date"/>
                                    <TextInput v-model="form.submission_date" type="date" class="form-control"  :light="true" />
                                </BCol>

                                <BCol lg="6" class="mt-2">
                                    <InputLabel for="supply_officer" value="Supply Officer" :message="form.errors.supply_officer_id"/>
                                    <Multiselect 
                                    :options="dropdowns.supply_officers" 
                                    v-model="form.supply_officer_id"
                                    :searchable="true" label="name"
                                    placeholder="Select Supply Officer"/>
                                </BCol>  
                                
                            </BRow>    
                        </b-card>
                    </div>
            </BCol>

     
            </BRow>
            <BRow>
                    <!-- <div  class="bg-info font-weight text-white" v-if="option == 'review_purchase_request'">ITEM LIST</div> -->
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="table-light">
                                <tr class="fs-11">
                                    <th>#</th>
                                    <th>Quantity/Unit</th>
                                    <th>Item Description</th>
                                    <th></th>
                                </tr>
                            </thead>                 
                            <tbody style="vertical-align: top;">
                                <tr v-for="(item, index) in form.items" :key="index">
                                    <td style="text-align:center">{{ index + 1 }}</td>
                                    <td style="text-align:center">{{ item.quantity }} {{ item.item_unit }}</td>
                                    <td >
                                        <div v-html="item.description"></div>
                                    </td>
                                    <td>
                                    <!-- <b-button v-if="option != 'quotations_purchase_request'" @click="removeItem(index)" variant="danger" size="sm">Remove</b-button> -->
                                    </td>
                                </tr>
                                </tbody>
                        </table>
                    </div>

                <BCol lg="3" class="mt-2 mb-2">
                    <b-button @click="createQuotation(form)"  variant="light" block class="bg-success w-75 text-white">Save</b-button>
                </BCol>
                <BCol lg="3" class="mt-2 mb-2">
                    <b-button @click="goBackPage(form)" style="background-color: grey" block class=" w-75 text-white">Back</b-button>
                </BCol>
            </BRow>

            </form>
            <div>
        </div> 


        </div>
    </div>

    <Confirm  :data="form" ref="create"/>
</template>
<script>
// import Lists from './Procurement/Purchase-Request/Components/Lists.vue';
import PageHeader from '@/Shared/Components/PageHeader.vue';
import { useForm } from '@inertiajs/vue3';
import Multiselect from "@vueform/multiselect";
import InputError from '@/Shared/Components/Forms/InputError.vue';
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
import TextInput from '@/Shared/Components/Forms/TextInput.vue';
import Checkbox from '@/Shared/Components/Forms/Checkbox.vue';
import Confirm from '../../Modals/Confirmation.vue';
import { router } from '@inertiajs/vue3';

export default {
    components: { Confirm, PageHeader, InputError, InputLabel, TextInput, Multiselect, Checkbox },
    props: ['dropdowns' , 'option'],
    data(){
        return {
                currentUrl: window.location.href,
                form: useForm({
                    id:  this.dropdowns.data.id,
                    supplier_id: null,
                    purchase_request_number: this.dropdowns.data.purchase_request_number ,
                    address: null,
                    purchase_request_date: this.dropdowns.data.purchase_request_date,
                    submission_date: null,
                    supply_officer_id: null,
                    items: this.dropdowns.item_details,
                    option: 'quotation_request',
                }),

                
                showModal: false,
                sections: [],
                unit_type : null,
            }
    }, 

    watch: {
        'form.supplier_id': function(value) {
            if(value){         
                this.getAddress(value);
            }
        }
    },

    methods: { 
        openAddItem(){
            this.$refs.create.show();
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

        getAddress(supplier_id){
            axios.get('/faims/purchase-requests',{
                params : {
                    supplier_id : supplier_id,
                    option: 'supplier_address'
                }
            })
            .then(response => {
                if(response){
                    this.form.address = response.data[0].address;   
                }
            })
            .catch(err => console.log(err));
        },

        createQuotation(data){
            router.post('/faims/quotation-requests', { data : data, option: 'save_rfq' });
            setTimeout(() => {
                this.$inertia.visit('/faims/quotation-requests/'+data.id+'?option=quotations');
            }, 2000); // Delay in milliseconds (2000 ms = 2 seconds)
          
            this.form.reset();   
        },

        goBackPage(data){
            this.$inertia.visit('/faims/quotation-requests/'+data.id+'?option=quotations');
        },

    }
}
</script>