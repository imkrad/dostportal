<template>
    <b-modal v-model="showModal" header-class="p-3"  :title="editable ? 'Update PAP' : 'New PAP'" size="lg" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop >
        <form class="customform">
           <BRow>
            <BCol lg="6" class="mt-2">
                <InputLabel value="Code" />
                <TextInput v-model="form.code" type="text" class="form-control" placeholder="Enter code"  />
            </BCol>
            <BCol lg="6" class="mt-2">
                <InputLabel value="Allocated Budget" />
                <TextInput v-model="form.allocated_budget" type="number" class="form-control" placeholder="0"  />
            </BCol>
            <BCol lg="12" class="mt-2">
                    <InputLabel for="mode_of_procurement" value="Mode of Procurement"/>
                    <Multiselect 
                    :options="mode_of_procurements" 
                    v-model="form.mode_of_procurement_id"
                    :searchable="true" label="mode"
                    placeholder="Mode of Procurement"/>
                </BCol>
            <BCol lg="12" class="mt-2">
                <InputLabel value="Project Description/Title" />
                <textarea
                    id="description"
                    v-model="form.title"
                    class="form-control"
                    rows="5"
                    placeholder="Enter project description/title"
                    ></textarea>
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
    props:['mode_of_procurements'],
    data(){
        return {
            currentUrl: window.location.origin,
            form: useForm({
                id: null,
                title: null,
                code: null,
                allocated_budget: null,
                mode_of_procurement_id: null,
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
            this.form.title = data.title;
            this.form.code = data.code;
            this.form.allocated_budget = data.allocated_budget;
            this.form.mode_of_procurement_id = data.mode_of_procurement.id;
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
        },

       
    }
}
</script>