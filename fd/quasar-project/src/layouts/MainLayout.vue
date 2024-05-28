<template>
  <q-layout view="lHh Lpr lFf" class="bg-color">
    <q-header elevated>
      <q-toolbar>
        <q-btn
          flat
          dense
          round
          icon="menu"
          aria-label="Menu"
          @click="toggleLeftDrawer"
          class="menu_button"
        />

        <q-toolbar-title>
          <span class="full_app_name"
            >Contacts Book
            <strong><small>(<q-icon name="grain" /> UZAPOINT)</small></strong>
                     </span>
          
        </q-toolbar-title>

        <div>
          <span>
            <q-btn-dropdown
              icon="power_settings_new"
              size="sm"
              flat
              :label="`${$q.screen.md || $q.screen.lg ? 'User Account' : ''}`"
            >
              <small>
                <div class="row no-wrap q-pa-md">                 
                  <div class="column items-center q-pa-0">
                    <q-avatar
                      icon="perm_identity"
                      color="primary"
                      style="font-size: 50px; color: white"
                    />
                    <div class="text-subtitle1 q-mt-md q-mb-xs">
                      User
                    </div>                  
                  </div>
                </div>              
              </small>
            </q-btn-dropdown>
          </span>
        </div>
      </q-toolbar>
    </q-header>

    <q-footer>
      <BottomLinks />
    </q-footer>

    <q-drawer
       v-model="leftDrawerOpen"
      show-if-above
      bordered
      :width="255"
      :breakpoint="767"
    >
      <Links />
    </q-drawer>

    <q-page-container>
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script setup>
import { ref } from "vue";
import { useQuasar } from "quasar";
import { useRouter } from "vue-router";

import Links from "src/components/Links.vue";
import BottomLinks from "src/components/BottomLinks.vue";

const router = useRouter();
const $q = useQuasar();



const leftDrawerOpen = ref(false);
const logoutLoading = ref(false);

const toggleLeftDrawer = () => (leftDrawerOpen.value = !leftDrawerOpen.value);


</script>
<style scoped>
.bg-color {
  /* background-color: aliceblue; */
  /* background: rgb(1, 126, 10); */
  background: linear-gradient(
    90deg,
    rgb(213, 246, 223) 0%,
    rgb(165, 240, 255) 100%
  );
}

@media screen and (min-width: 768px) {
  .q-footer {
    display: none;
  }
  .app_name {
    display: none;
  }
}

@media screen and (max-width: 768px) {
  .menu_button {
    display: none;
  }
  .full_app_name {
    display: none;
  }
}
</style>
