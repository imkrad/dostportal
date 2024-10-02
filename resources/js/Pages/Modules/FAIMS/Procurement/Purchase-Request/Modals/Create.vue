<template>
    <b-modal v-model="showModal" header-class="p-3" title="Add Item" size="lg" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop >
        <form class="customform">
            <BRow>
                <BCol lg="12" class="mt-2">
                    <ckeditor v-model="form.item_description" :editor="editor"></ckeditor>
                </BCol>
                <BCol lg="12" class="mt-2">
                    <InputLabel for="unit_type" value="Unit Type"/>
                    <Multiselect 
                    :options="dropdowns.unit_types" 
                    v-model="form.item_unit_id"
                    :searchable="true" label="name_long"
                    placeholder="Select Item Unit Type"/>
                </BCol>
                <BCol lg="6" class="mt-2">
                    <InputLabel value="Quantity" />
                    <TextInput v-model="form.item_quantity" type="number" class="form-control" placeholder="0"  />
                </BCol>
                <BCol lg="6" class="mt-2">
                    <InputLabel value="Price"/>
                    <TextInput v-model="form.item_price" type="number" class="form-control" placeholder="0.00"/>
                </BCol>
                <BCol lg="12"><hr class="text-muted mt-4 mb-0"/></BCol>
            </BRow>
        </form>


   
          <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Cancel</b-button>
            <b-button @click="addItem('ok')" variant="primary" :disabled="form.processing" block>add</b-button>
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
                pr_id: null,
                item_description: '',
                item_unit: null,
                item_unit_id: null,
                item_quantity: 0,
                item_price: null,
                total_cost : 0
            }),
            itemsAdded: [],
            unit_type: null,
            showModal: false,
		    editor: ClassicEditor,
        }
    },

    watch: {
        'form.item_unit_id': function(value) {
            if(value){
                this.getItemUnitType(value);
            }
        }
    },




    methods: { 

        show(){
            this.form.reset();
            this.showModal = true;
        },

        addItem() {
            // Adds a new item object with default values
            this.itemsAdded.push({
                item_unit: this.form.item_unit,
                item_unit_id: this.form.item_unit_id,
                description: this.form.item_description,
                quantity: this.form.item_quantity,
                unit_cost: this.form.item_price,
                total_cost: this.form.item_price * this.form.item_quantity,
            });

            this.$emit('items', this.itemsAdded);
            this.hide();
        },

        getItemUnitType(unit_type_id) {
            axios.get('/faims/purchase-request',{
                params : {
                    unit_type_id : unit_type_id,
                    option: 'unit_type'
                }
            })
            .then(response => {
                if(response){
                    this.form.item_unit = response.data[0].name_long;         
                }
            })
            .catch(err => console.log(err));
        },
      
      
        hide(){
            this.form.reset();
            this.showModal = false;
        },

       
    }
}
</script>