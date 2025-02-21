<template>
    <b-modal v-model="showModal" header-class="p-3" title="Generate BAC Resolution" size="lg" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop >
        <form class="customform">
           <BRow>
                <BCol lg="6" class="mt-2">
                    <InputLabel value="Purchase Request No."/>
                    <TextInput v-model="bac_reso_number"  type="text" class="form-control"  :light="true" />
                </BCol>
                <BCol lg="6" class="mt-2">
                    <InputLabel for="supplier" value="Supplier"/>
                    <Multiselect 
                    v-model="form.supplier_id"
                    :searchable="true" label="name"
                    placeholder="Select Supplier"/>
                </BCol>
            </BRow>
        </form>
   
          <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Close</b-button>
            <b-button @click="goNext(data)" variant="success"  block>Yes</b-button>
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

export default {
    components: { InputError, InputLabel, TextInput, Multiselect, ckeditor: CKEditor.component  },
    props:['data'],
    data(){
        return {
            currentUrl: window.location.origin,
            form: useForm({
                id: null,
                pr_id: null,
                pr_no: null,
                items: {},
                supplier_id: null,
                is_checked : null,
                type: null
            }),
            currentUrl: window.location.origin,        
            showModal: false,
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



       
    }
}
</script>