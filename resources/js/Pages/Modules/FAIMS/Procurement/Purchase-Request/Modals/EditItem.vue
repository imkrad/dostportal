<template>
    <b-modal v-model="showModal" header-class="p-3" title="Edit Item" size="lg" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop >
        <form class="customform">
            <BRow>
                <BCol lg="12" class="mt-2" v-if="action_type == 'edit_description'">
                    <ckeditor v-model="form.description" :editor="editor"></ckeditor>
                </BCol>
                <BCol lg="6" class="mt-2" v-if="action_type == 'edit_bid_price'">
                    <InputLabel value="Bid Price"/>
                    <TextInput v-model="form.item_bid_price"  type="Number" class="form-control"  :light="true" />
                </BCol>
                <BCol lg="12" class="mt-2" v-if="action_type == 'edit_bid_price'">
                    <InputLabel value="Remarks"/>
                    <b-form-textarea
                    id="textarea"
                    v-model="form.remarks"
                    placeholder="Enter your remarks"
                    rows="5"
                    max-rows="10"></b-form-textarea>
                       
                </BCol>
                <BCol lg="12"><hr class="text-muted mt-4 mb-0"/></BCol>
            </BRow>
        </form>

          <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Cancel</b-button>
            <b-button v-if="action_type == 'edit_description'" @click="updateItemDescription(form)" variant="primary" :disabled="form.processing" block>update</b-button>
            <b-button v-if="action_type == 'edit_bid_price'" @click="updateItemBidPrice(form)" variant="primary" :disabled="form.processing" block>update</b-button>
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
import { router } from '@inertiajs/vue3';


export default {
    components: { InputError, InputLabel, TextInput, Multiselect, ckeditor: CKEditor.component  },
    props:['dropdowns'],
    data(){
        return {
            currentUrl: window.location.origin,
            form: useForm({
                id: null,
                index: null,
                description: '',
                item_bid_price: null,
                remarks: null,
            }),
            action_type: null,
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

        edit(data, index, action_type){
            this.showModal = true;
            this.action_type = action_type;
            this.form.id= data.id;
            this.form.index= index;
            if(action_type == "edit_description"){
                this.form.description= data.bids_description;
            }
            else if(action_type == "edit_bid_price"){
                this.form.item_bid_price= data.bids_price;
                this.form.remarks= data.remarks;
            }
         
        },

        updateItemDescription(data){
            router.post('/faims/bids' , { data: data, option: 'save_bids_description'});
            this.hide();
        },
    
        updateItemBidPrice(data){
            router.post('/faims/bids' , { data: data, option: 'save_bids_price'});
            this.hide();
        },
    
        hide(){
            this.form.reset();
            this.showModal = false;
        },

       
    }
}
</script>