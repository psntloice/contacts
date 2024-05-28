<template>
  <div>
    <q-list>
      <q-item-label header class="text-center"> Menu </q-item-label>
      <q-separator color="primary" />
      

      <q-item clickable to="/contacts">
        <q-item-section avatar>
          <q-icon name="style" size="2em" />
        </q-item-section>

        <q-item-section>
          <q-item-label>Contacts</q-item-label>
        </q-item-section>
      </q-item>
      <q-separator />

      <q-item clickable to="/groups">
        <q-item-section avatar>
          <q-icon name="bubble_chart" size="2em"/>
        </q-item-section>

        <q-item-section>
          <q-item-label>Groups</q-item-label>
        </q-item-section>
      </q-item>
      <q-separator />

    
    </q-list>
  </div>
</template>


<style scoped>
.heavy {
  font-weight: 700;
}
</style>