<template>
  <div class="q-pa-md">
    
    <div class="q-pa-md" style="max-width: 400px">

<q-form
  @submit="onSubmit"
  @reset="onReset"
  class="q-gutter-md"
>
  <q-input
    filled
    v-model="gname"
    label="Name *"
    hint="Name of group"
    lazy-rules
    :rules="[ val => val && val.length > 0 || 'Please type something']"
  />
  <q-input
    filled
    v-model="description"
    label="Description"
    
  />


  <div>
    <q-btn label="Submit" type="submit" color="primary"/>
    <q-btn label="Reset" type="reset" color="primary" flat class="q-ml-sm" />
  </div>
</q-form>

</div>
<div v-if="isLoading">Loading... 
 </div>

  <div v-else class="q-pa-md">
    <q-table
      :rows= allGroups
      :columns = "columns"
      row-key="group_name"
      grid
       flat bordered
      hide-header
    >
    <template v-slot:item="props">
 <div
          class="q-pa-xs col-xs-12 col-sm-6 col-md-4 col-lg-3 grid-style-transition"
          :style="props.selected ? 'transform: scale(0.95);' : ''">
          <q-card bordered  :class="props.selected ? ($q.dark.isActive ? 'bg-grey-9' : 'bg-grey-2') : ''">

            <q-card-section class="text-center">
<q-toolbar class="bg-primary text-white shadow-2">
      <q-toolbar-title><strong>{{ props.row.group_name }}</strong></q-toolbar-title>
    </q-toolbar>
              
            </q-card-section>
            <q-separator />
            <q-list bordered>
             
               <q-item v-for="contact in props.row.contacts" :key="contact.id" class="q-my-sm" clickable v-ripple>
        <q-item-section avatar>
          <q-avatar color="primary" text-color="white">
            {{ contact.letter }}
          </q-avatar>
        </q-item-section>

        <q-item-section>
          <q-item-label>{{ contact.first_name }}</q-item-label>
          <q-item-label caption lines="1">{{ contact.email }}</q-item-label>
        </q-item-section>

       
        <q-item-section side top>
          <q-item-label caption lines="1"><q-btn flat icon="delete" @click="removeContact(props.row, contact)" /></q-item-label>
                  </q-item-section>
      </q-item>
            </q-list>
            <q-separator />
            
              <q-card-actions align="right">
                <q-btn flat label="Edit" @click="editGroup(props.row)" />
                <q-btn flat label="Delete" color="negative" @click="deleteGroup(props.row)" />
              </q-card-actions>
          </q-card>
        </div>
      </template>
    </q-table>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useQuasar } from 'quasar'
import { useContactStore } from "src/stores/contact_store";
const contactStore = useContactStore();
import { useQuery, useMutation } from "vue-query";
const { data: allGroups, isLoading: isLoading, error: error, refetch: refetch } = useQuery("contacts", contactStore.fetchGroups);

const columns = [
  { name: 'group_name', required: true, label: 'Group Name', field: 'group_name', sortable: true, align: 'left' },
  { name: 'description', label: 'Description', field: 'description', sortable: true, align: 'left' },
  { 
    name: 'contacts', 
    label: 'Contacts', 
    field: 'contacts', 
    sortable: false, 
    align: 'left', 
    format: contacts => contacts.map(contact => contact.first_name + ' ' + contact.last_name).join(', ') 
  },
];

    const $q = useQuasar();
    const gname = ref('');
const description = ref('');
    const { mutate: createGroup, isLoading2 } = useMutation({
  mutationFn: async (groupData) => {
    await contactStore.createGroups(groupData);
    console.log("we here");
    $q.notify({
            color: 'blue-4',
            textColor: 'white',
            icon: 'cloud_done',
            message: 'Group Created'
          })
  },
});
const { mutate: deleteGroup } = useMutation({
  mutationFn: async (groupId) => {
    // Dispatch action to create contact in Vuex store
    await contactStore.deleteGroups(groupId);
            $q.notify({
            color: 'blue-4',
            textColor: 'white',
            icon: 'cloud_done',
            message: 'Group Deleted'
          })
  },
});

const { mutate: updateGroup } = useMutation({
  mutationFn: async ({ groupId, groupData }) => {
    // Dispatch action to update contact in Vuex store
    await contactStore.updateGroups(groupId, groupData);
    console.log("we here", groupId, groupData);
            $q.notify({
            color: 'blue-4',
            textColor: 'white',
            icon: 'cloud_done',
            message: 'Group Updated'
          })
  },
});
const selectedGroupId = ref(null);

const onUpdate = (row) => {
  selectedGroupId.value = row.id;
  gname.value = row.group_name;
  description.value = row.description;
  
}

const onDelete = async (row) => {
  console.log('Delete row:', row.id)
  await deleteGroup(row.id);
}
const onSubmit = async () => {
  const groupData = {
    group_name: gname.value,
    description: description.value,
   
  };

if (selectedGroupId.value!==null) {
  const groupData = {
    group_name: gname.value,
    description: description.value,
    
  };
 const groupId = selectedGroupId.value;
  await updateGroup({ groupId, groupData });
    
} else {
await createGroup(groupData);
  
}

selectedGroupId.value = null;
  onReset();
};

     const onReset = () => {
      gname.value = '';
      description.value = '';
  
    }   
</script>
