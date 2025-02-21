<template>
    <b-modal v-model="showModal" header-class="p-3" title="Create Purchase Order" size="lg" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop >
        <form class="customform">
           <BRow>
                <BCol lg="6" class="mt-2">
                    <InputLabel for="supplier" value="Supplier"/>
                    <Multiselect 
                    :options="dropdowns.suppliers"
                    v-model="form.supplier_id"
                    :searchable="true" label="name"
                    placeholder="Select Supplier"/>
                </BCol>
                <BCol lg="6" class="mt-2">
                    <InputLabel value="Address" :message="form.errors.adress"/>
                    <TextInput v-model="form.address" type="text" class="form-control"  :light="true"/>
                </BCol>
            </BRow>
            <BRow>
                <BCol lg="6" class="mt-2">
                    <InputLabel value="TIN"/>
                    <TextInput v-model="form.tin"  type="text" class="form-control"  :light="true" />
                </BCol>
                <BCol lg="6" class="mt-2">
                    <InputLabel value="Date"/>
                    <TextInput v-model="form.date"  type="date" class="form-control"  :light="true" />
                </BCol>
                <BCol lg="12" class="mt-2">
                    <InputLabel for="mode_of_procurement" value="Mode of Procurement"/>
                    <Multiselect 
                    :options="mode_of_procurement" 
                    v-model="form.mode_of_procurement"
                    :searchable="true" label="name"
                    placeholder=""/>
                </BCol>

                <BCol lg="6" class="mt-2">
                    <InputLabel value="Place of Delivery"/>
                    <TextInput v-model="form.place_of_delivery"  type="text" class="form-control"  :light="true" />
                </BCol>

                <BCol lg="6" class="mt-2">
                    <InputLabel value="Date of Delivery"/>
                    <TextInput v-model="form.delivery_date"  type="date" class="form-control"  :light="true" />
                </BCol>

                <BCol lg="6" class="mt-2">
                    <InputLabel value="Delivery Term"/>
                    <TextInput v-model="form.delivery_term"  type="text" class="form-control"  :light="true" />
                </BCol>

                <BCol lg="6" class="mt-2">
                    <InputLabel value="Payment Term"/>
                    <TextInput v-model="form.payment_term"  type="text" class="form-control"  :light="true" />
                </BCol>

                <!-- <div style="margin-top: 20px; background: darkblue; color:white">
                    ASSIGNATOREES
                </div>

                <BCol lg="6" class="mt-2">
                    <InputLabel for="authorized_official" value="Authorized Official"/>
                    <TextInput value="MARTIN A. WEE"  type="text" class="form-control"  :light="true" />
                </BCol>
                <BCol lg="6" class="mt-2">
                    <InputLabel value="Designation"/>
                    <TextInput value="REGIONAL DIRECTOR"  type="text" class="form-control"  :light="true" readonly/>
                </BCol>
                <BCol lg="12" class="mt-2">
                    <InputLabel value="Chief of Accountant/Head of the Accounting Division/Unit"/>
                    <TextInput value="INGRID T. ABELLA-COLCOL"  type="text" class="form-control"  :light="true" readonly/>
                </BCol>

                <p >Note:<span style="color: red">You can change the assignatorees above in the libraries</span> </p>
              -->
            </BRow>
        </form>
   
          <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Close</b-button>
            <b-button @click="savePO()" variant="success"  block>Save</b-button>
        </template>
        
    </b-modal>
</template>
<script>
import { useForm } from '@inertiajs/vue3';
import Multiselect from "@vueform/multiselect";
import InputError from '@/Shared/Components/Forms/InputError.vue';
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
import TextInput from '@/Shared/Components/Forms/TextInput.vue';
import CKEditor from "@ckeditor/ckeditor5-vue";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
import { maxBy } from 'lodash';

export default {
    components: { InputError, InputLabel, TextInput, Multiselect, ckeditor: CKEditor.component  },
    props:['dropdowns'],
    data(){
        return {
            currentUrl: window.location.origin,
            form: useForm({
                id: null,
                supplier_id: null,
                address: null,
                tin: null,
                date: null,
                mode_of_procurement: null,
                place_of_delivery: null,
                date_delivery: null,
                delivery_term: null,
                payment_term: null,              
            }),
            currentUrl: window.location.origin,        
            showModal: false,

            mode_of_procurement: [
                "Competitive Public Bidding",
                "Limited Source Bidding",
                "Direct Contracting",
                "Repeat Order",
                "Shopping",
                "Negotiated Two Failed Biddings",
                "Negotiated Emergency Cases",
                "Take-Over of Contracts",
                "Adjacent or Contiguous",
                "Agency-to-Agency",
                "Scientific, Scholarly or Artistic Work, Exclusive Technology and Media Services",
                "Highly Technical Consultants",
                "Defense Cooperation Agreement",
                "Small Value Procurement",
                "Lease of Real Property and Venue",
                "NGO Participation",
                "Community Participation",
                "United Nations Agencies, International Organizations or International Financing Institutions"
            ],
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

        show(){
            // this.form.reset();
            this.showModal = true;
        },
      
        hide(){
            // this.form.reset();
            this.showModal = false;
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

      



       
    }
}
</script>