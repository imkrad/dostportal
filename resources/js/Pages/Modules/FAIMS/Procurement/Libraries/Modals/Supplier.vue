<template>
    <b-modal v-model="showModal" header-class="p-3"  :title="editable ? 'Update Supplier' : 'New Supplier'" size="lg" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop >
        <form class="customform">
           <BRow>
            <BCol lg="12" class="mt-2">
                <InputLabel value="Supplier Name" />
                <TextInput v-model="form.name" type="text" class="form-control" placeholder="Enter Full Name(Firstname Middle Initial. Lastname Suffix)"  />
            </BCol>
            <BCol lg="12" class="mt-2">
                <InputLabel value="Address" />
                <textarea
                    id="address"
                    v-model="form.address"
                    class="form-control"
                    rows="5"
                    placeholder="Enter address"
                    ></textarea>
            </BCol>
            <BCol lg="6" class="mt-2">
                <InputLabel value="Mayor's Permit No." />
                <TextInput v-model="form.mayors_permit_no" type="text" class="form-control" placeholder="Enter Mayor's Permit No."  />
            </BCol>
            <BCol lg="6" class="mt-2">
                <InputLabel value="TIN" />
                <TextInput v-model="form.tin" type="text" class="form-control" placeholder="Enter TIN"  />
            </BCol>
        </BRow>
        </form>
   
          <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Close</b-button>
            <b-button @click="savePAP(form)" variant="success"  block>Save</b-button>
        </template>
        
    </b-modal>
</template>
<script>
import { useForm } from '@inertiajs/vue3';
import Multiselect from "@vueform/multiselect";
import InputError from '@/Shared/Components/Forms/InputError.vue';
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
import TextInput from '@/Shared/Components/Forms/TextInput.vue';
import { router } from '@inertiajs/vue3';

export default {
    components: { InputError, InputLabel, TextInput, Multiselect },
    props:['dropdowns'],
    data(){
        return {
            currentUrl: window.location.origin,
            form: useForm({
                id: null,
                name: null,
                address: null,
                mayors_permit_no: null,
                tin: null,
            }),    
            showModal: false,
            editable: false,
        }
    },

    methods: { 

        show(){
            this.editable = false;
            this.form.reset();
            this.showModal = true;
        },

        edit(data){
            this.editable= true;
            this.form.id = data.id;
            this.form.name = data.name;
            this.form.address = data.address;
            this.form.mayors_permit_no = data.mayors_permit_no;
            this.form.tin = data.tin;
            this.showModal = true;
        },
      
        hide(){
            this.form.reset();
            this.showModal = false;
        },

        savePAP(data){ 
            if(this.editable){
                this.form.put(`/faims/libraries/pap-codes/`+data.id,{
                    preserveScroll: true,
                    onSuccess: (response) => {
                        this.$emit('update', true);
                        this.form.reset();
                        this.hide();
                    }
                });
            }else{
                this.form.post('/faims/libraries/pap-codes',{
                preserveScroll: true,
                onSuccess: (response) => {
                    this.$emit('add',true);
                    this.hide();
                },
            });
            }
        }

       
       
    }
}
</script>