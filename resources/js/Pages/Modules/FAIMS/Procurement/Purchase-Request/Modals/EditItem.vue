<template>
    <b-modal v-model="showModal" header-class="p-3" title="Edit Bid Offer" size="lg" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop >
        <form class="customform">
            <BRow>
                <BCol lg="6" class="mt-2">
                    <InputLabel value="Bid Price"/>
                    <TextInput v-model="form.item_bid_price"  type="Number" class="form-control"  :light="true" />
                </BCol>
                <BCol lg="12" class="mt-2" >
                    <InputLabel value="Technical Proposal"/>
                    <ckeditor v-model="form.technical_proposal" :editor="editor"></ckeditor>
                </BCol>
                <BCol lg="12" class="mt-2" >
                    <InputLabel value="Delivery Term"/>
                    <TextInput v-model="form.delivery_term"  type="text" class="form-control"  :light="true" />
                </BCol>
                <BCol lg="12"><hr class="text-muted mt-4 mb-0"/></BCol>
            </BRow>
        </form>

          <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Cancel</b-button>
            <b-button  @click="updateItemBidOffer(form)" variant="primary" :disabled="form.processing" block>update</b-button>
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


export default {
    components: { InputError, InputLabel, TextInput, Multiselect, ckeditor: CKEditor.component  },
    props:['dropdowns'],
    data(){
        return {
            currentUrl: window.location.origin,
            form: useForm({
                id: null,
                index: null,
                item_description: '',
                item_bid_price: null,
                technical_proposal: '',
                delivery_term: '7 days upon received of PO',
                option: null,
            }),
            editor: ClassicEditor,
            editorData: '',
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
        },



    },


    methods: { 

        show(){
            this.form.reset();
            this.showModal = true;
        },

        edit(bid_item){
            this.showModal = true;
            this.form.id= bid_item.bid_item_id;
            this.form.item_description = bid_item.item_description;
            if(bid_item.technical_proposal){
                bid_item.technical_proposal= bid_item.technical_proposal;
            }
            else{
                this.form.technical_proposal= bid_item.item_description;
            }
           
            this.form.item_bid_price= bid_item.item_bid_price;
        },

    
       updateItemBidOffer(data) {
            this.form.option = 'save_bid_offer';

            this.form.post('/faims/bids', {
                onSuccess: () => {
                this.hide(); // Hide only when successful
                },
                onError: () => {
                // Optionally handle errors
                console.error('Failed to update bid price');
                },
            });
        },

    
        hide(){
            this.form.reset();
            this.showModal = false;
        },

       
    }
}
</script>