<template>
    <div class="p-3 d-flex flex-column h-100">
        <b-row class="g-2 mt-0">
            <b-col lg>
                <div class="input-group mb-1">
                    <span class="input-group-text"> <i class="ri-search-line search-icon"></i></span>
                    <input type="text" placeholder="Search Rate" class="form-control" style="width: 60%;">
                </div>
            </b-col>
        </b-row>
        <div class="table-responsive">
            <table class="table table-nowrap align-middle mb-0 mt-2">
                <thead class="table-light">
                    <tr class="fs-11">
                        <th class="text-center">Grade</th>
                        <th style="width: 85%;">Salary Monthly</th>
                        <th style="width: 7%;"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(list,index) in salaries" v-bind:key="index" :class="(list.onhand == 0) ? 'bg-danger-subtle' : ''">
                        <td class="text-center">{{ list.grade }}</td>
                        <td>{{ list.amount }}</td>
                        <td class="text-end">
                            <b-button @click="openEdit(list,index)" variant="soft-warning" class="me-1" v-b-tooltip.hover title="Edit" size="sm">
                                <i class="ri-pencil-fill align-bottom"></i>
                            </b-button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script>
export default {
    props: ['salaries']
}
</script>