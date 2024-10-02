<template>
    <PageHeader title="Create Purchase Request" pageTitle="List" />
    <div class="chat-wrapper d-lg-flex gap-1 mx-n4 mt-n4 p-1">
        <div class="file-manager-content w-100 p-4 pb-0" style="height: calc(100vh - 180px); overflow: auto;" ref="box">
            <!-- <Lists :dropdowns="dropdowns"/>         -->
            <form class="customform">
                <BRow>
                    <BCol lg="6" class="mt-2">
                    <div>
                        <b-card  class="bg-light">             
                            <BRow>
                                <BCol lg="6" class="mt-2">
                                    <InputLabel for="division" value="Division" :message="form.errors.division_id"/>
                                    <Multiselect 
                                    :options="dropdowns.divisions" 
                                    v-model="form.division_id"
                                    :searchable="true" label="name"
                                    placeholder="Select Division"/>
                                </BCol>

                                <BCol lg="6" class="mt-2">
                                    <InputLabel value="PR Date" :message="form.errors.purchase_request_date"/>
                                    <TextInput v-model="form.purchase_request_date" type="date" class="form-control"  :light="true" readonly/>
                                </BCol>
                                <BCol lg="6" class="mt-2">
                                    <InputLabel for="section" value="Section" :message="form.errors.section_id"/>
                                    <Multiselect 
                                    :options="sections" 
                                    v-model="form.section_id"
                                    :searchable="true" label="name"
                                    placeholder="Select Section"/>
                                </BCol>

                                <BCol lg="6" class="mt-2">
                                    <InputLabel for="fund_cluster" value="Fund Cluster" :message="form.errors.fund_cluster_id"/>
                                    <Multiselect 
                                    :options="dropdowns.fund_clusters" 
                                    v-model="form.fund_cluster_id"
                                    :searchable="true" label="name"
                                    placeholder="Select Fund Cluster"/>
                                </BCol>
                                
                            </BRow>    
                        </b-card>
                    </div>
            </BCol>
            <BCol lg="6" class="mt-2">
                    <div>
                        <b-card  class="bg-light">             
                            <BRow>
                                <BCol lg="12" class="mt-2">
                                    <InputLabel for="purchase_request_purpose" value="Request Purpose" :message="form.errors.purchase_request_purpose"/>
                                    <b-form-textarea
                                        id="textarea"
                                        v-model="form.purchase_request_purpose"
                                        placeholder="Enter your request purpose"
                                        rows="5"
                                        max-rows="10"></b-form-textarea>
                                </BCol>

                                
                            </BRow>    
                        </b-card>
                    </div>
            </BCol>
     
            </BRow>
                <BRow>
                    <BCol lg="3" class="mt-2 mb-2">
                        <b-button @click="openAddItem()" variant="light" block class="bg-success w-75 text-white">Add Item</b-button>
                    </BCol>

                    <div class="table-responsive">
                        <table class="table table-nowrap align-middle mb-0">
                            <thead class="table-light">
                                <tr class="fs-11">
                                    <th>#</th>
                                    <th>Unit</th>
                                    <th>Item Description</th>
                                    <th>Quantity</th>
                                    <th>Unit Cost</th>
                                    <th>Total Cost</th>
                                    <th></th>
                                </tr>
                            </thead>                 
                            <tbody>
                                <tr v-for="(item, index) in form.items" :key="index">
                                    <td>{{ index + 1 }}</td>
                                    <td>{{ item.item_unit }}</td>
                                    <td>
                                        <div v-html="item.description"></div>
                                    </td>
                                    <td>{{ item.quantity}}</td>
                                    <td>{{ formatCurrency(item.unit_cost) }}</td>
                                    <td>{{ formatCurrency(item.total_cost) }}</td>
                                    <td>
                                    <b-button @click="removeItem(index)" variant="danger" size="sm">Remove</b-button>
                                    </td>
                                </tr>
                                </tbody>
                        </table>
                    </div>

                    <BCol lg="12" class="mt-5">
                    <div>
                        <b-card title="ASSIGNATOREES"  class="bg-light">             
                            <BRow>
                                <BCol lg="6" class="mt-2">
                                    <InputLabel for="division" value="Requested By" :message="form.errors.requested_by"/>
                                    <Multiselect 
                                    :options="dropdowns.requesters" 
                                    v-model="form.requested_by"
                                    :searchable="true" label="name"
                                    placeholder="Select Requester"/>
                                </BCol>
                                <BCol lg="6" class="mt-2">
                                    <InputLabel for="division" value="Approved By" :message="form.errors.approved_by"/>
                                    <Multiselect 
                                    :options="dropdowns.approvers" 
                                    v-model="form.approved_by"
                                    :searchable="true" label="name"
                                    placeholder="Select Approver"/>
                                </BCol>
                                
                            </BRow>    
                        </b-card>
                    </div>
            </BCol>
            <BCol lg="3" class="mt-2 mb-2">
                <b-button @click="submit('ok')"  variant="light" block class="bg-success w-75 text-white">Save</b-button>
            </BCol>
            <BCol lg="3" class="mt-2 mb-2">
                <b-button @click="goBackPage()" style="background-color: grey" block class=" w-75 text-white">Cancel</b-button>
            </BCol>
                </BRow>
            </form>
        </div>
    </div>

    <Create :dropdowns="dropdowns"  @items="handleItems"   ref="create"/>
</template>
<script>
// import Lists from './Procurement/Purchase-Request/Components/Lists.vue';
import PageHeader from '@/Shared/Components/PageHeader.vue';
import { useForm } from '@inertiajs/vue3';
import Multiselect from "@vueform/multiselect";
import InputError from '@/Shared/Components/Forms/InputError.vue';
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
import TextInput from '@/Shared/Components/Forms/TextInput.vue';
import Create from '../Modals/Create.vue';
import { router } from '@inertiajs/vue3';

export default {
    components: { Create, PageHeader, InputError, InputLabel, TextInput, Multiselect },
    props: ['dropdowns' ,],
    data(){
        return {
            currentUrl: window.location.origin,
            form: useForm({
                id: null,
                request_number: null,
                division_id : null,
                section_id : null,
                purchase_request_date: this.getCurrentDate(),
                fund_cluster_id: null,
                purchase_request_purpose: null,   
                items: [],
                requested_by: null,
                approved_by: null,
                status_id: 1,
                option: 'purchase-request',
                
            }),
            showModal: false,
            sections: [],
            unit_type : null,
        }
    },

    watch: {
        'form.division_id': function(value) {
            if(value){
                this.getSections(value);
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



        getSections(division_id) {
            axios.get('/faims/purchase-request',{
                params : {
                    division_id : division_id,
                    option: 'sections'
                }
            })
            .then(response => {
                if(response){
                    this.sections = response.data;   
                }
            })
            .catch(err => console.log(err));
        },

        handleItems(updatedItems) {
            // Update the parent component's `items` array
            this.form.items = updatedItems;
            
        },

        removeItem(index) {
        // Removes an item from the array based on its index
            this.form.items.splice(index, 1);
        },

        submit(){
            this.form.post('/faims/purchase-request');
            this.form.reset();    
        },

        
        formatCurrency(value) {
            return new Intl.NumberFormat('en-PH', {
            style: 'currency',
            currency: 'PHP',
            }).format(value);
        },


        goBackPage(){
            router.get('/faims/purchase-request');
        },

            

       
    }
}
</script>