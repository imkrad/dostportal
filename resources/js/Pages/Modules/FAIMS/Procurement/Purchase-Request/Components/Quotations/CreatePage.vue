<template>
    <PageHeader title="Request For Quotation" pageTitle="Quotation" />
    <div class="chat-wrapper d-lg-flex gap-1 mx-n4 mt-n4 p-1">
        <div class="file-manager-content w-100 p-4 pb-0" style="height: calc(100vh - 180px); overflow: auto;" ref="box">
            <form class="customform">
                <BRow>
                    <BCol lg="12" class="mt-2">
                    <div>
                        <b-card  class="bg-light">             
                            <BRow>

                                <BCol lg="6" class="mt-2">
                                    <InputLabel for="supplier" value="Supplier" />
                                    <Multiselect
                                        :options="filteredSuppliers"
                                        v-model="form.supplier_ids"
                                        :searchable="true"
                                        label="name"
                                        mode="tags"
                                        placeholder="Select Supplier"
                                    />
                                </BCol>

                                <BCol lg="6" class="mt-2">
                                    <InputLabel value="PR Number" />
                                    <TextInput v-model="purchase_request.purchase_request_number" type="text" class="form-control"  :light="true" readonly/>
                                </BCol>

                                <BCol lg="6" class="mt-2">
                                    <InputLabel value="Date" />
                                    <TextInput v-model="purchase_request.purchase_request_date" type="text" class="form-control"  :light="true" readonly/>
                                </BCol>

                                <BCol lg="6" class="mt-2">
                                    <InputLabel value="Submissions not Later than " :message="form.errors.submission_date"/>
                                    <TextInput v-model="form.submission_not_later_than" type="date" class="form-control"  :light="true" />
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
                                    <th>Item No</th>
                                    <th>Quantity/Unit</th>
                                    <th>Item Description</th>
                                    <th></th>
                                </tr>
                            </thead>                 
                            <tbody style="vertical-align: top;">
                                <tr v-for="(item, index) in form.items" :key="index">
                                    <td >{{ item.item_no }}</td>
                                  <td>
                                        {{ item.item_quantity }} 
                                        {{ item.item_quantity > 1 ? item.item_unit_type.name_long : item.item_unit_type.name_short }}
                                    </td>

                                    <td >
                                        <div v-html="item.item_description"></div>
                                    </td>
                                    <td>
                                    <!-- <b-button v-if="option != 'quotations_purchase_request'" @click="removeItem(index)" variant="danger" size="sm">Remove</b-button> -->
                                    </td>
                                </tr>
                                </tbody>
                        </table>
                    </div>

                <BCol lg="3" class="mt-2 mb-2">
                    <b-button @click="createQuotation(form.purchase_request_id)"  variant="light" block class="bg-success w-75 text-white">Save</b-button>
                </BCol>
                <BCol lg="3" class="mt-2 mb-2">
                    <b-button @click="goBackPage(form.purchase_request_id)" style="background-color: grey" block class=" w-75 text-white">Back</b-button>
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
    props: ['purchase_request' ,'items','dropdowns' , 'option' , 'user'],
    data(){
        return {
                currentUrl: window.location.href,
                form: useForm({
                    id:  null,
                    purchase_request_id: this.purchase_request.id,
                    supplier_ids: null,
                    submission_not_later_than: this.getDatePlusWorkingDays(7),
                    supply_officer_id: this.user.data.id,
                    items: this.items,
                    option: 'quotation_request',
                }),
                list_of_existed_rfq: [],
                showModal: false,
                sections: [],
                unit_type : null,
            }
    }, 


    mounted() {
        this.getExistedRFQ();
    },

    computed: {
        filteredSuppliers() {
            const allSuppliers = this.dropdowns.suppliers || [];

            const existedIds = (this.list_of_existed_rfq || []).map(item =>
                typeof item === 'object' ? item.value : item
            );

            const selectedIds = (this.form.supplier_ids || []).map(item =>
                typeof item === 'object' ? item.value : item
            );

            const excludeIds = new Set([...existedIds, ...selectedIds]);

            return allSuppliers.filter(supplier => !excludeIds.has(supplier.value));
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


        createQuotation(purchase_request_id){
            this.form.option = 'save_rfq';
            this.form.post('/faims/quotation-requests');
            
            setTimeout(() => {
              this.$inertia.visit('/faims/quotation-requests/'+purchase_request_id+'?option=quotations');
            }, 2000); // Delay in milliseconds (2000 ms = 2 seconds)
          
            this.form.reset();   
        },

        goBackPage(purchase_request_id){
            console.log(purchase_request_id, 999);
            this.$inertia.visit('/faims/quotation-requests/'+purchase_request_id+'?option=quotations');
        },

        getExistedRFQ(page_url){
            page_url = '/faims/quotation-requests' ;
            axios.get(page_url,{
                params : {
                    option: 'list_of_existed_rfq',
                    purchase_request_id: this.purchase_request.id,
                }
            })
            .then(response => {
                if(response){    
                    this.list_of_existed_rfq = response.data;
                }
            })
            .catch(err => console.log(err));

        },

        getDatePlusWorkingDays(days) {
            let date = new Date();
            let addedDays = 0;

            while (addedDays < days) {
                date.setDate(date.getDate() + 1);
                const dayOfWeek = date.getDay();
                if (dayOfWeek !== 0 && dayOfWeek !== 6) {
                    addedDays++;
                }
            }

            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');

            return `${year}-${month}-${day}`;
        }


        
    }
}
</script>