<template>
  <div class="breadcrumbs text-sm">
    <ul>
      <li v-for="(crumb, index) in breadcrumbs" :key="index">
        <router-link v-if="crumb.path" :to="crumb.path">{{ crumb.name }}</router-link>
        <span v-else>{{ crumb.name }}</span>
      </li>
    </ul>
  </div>
</template>

<script setup>
import { computed } from "vue";
import { useRoute, useRouter } from "vue-router";

const route = useRoute();
const router = useRouter();

const breadcrumbs = computed(() => {
  const pathArray = route.path.split("/").filter((p) => p);
  let path = "";
  return pathArray.map((segment, index) => {
    path += `/${segment}`;
    return {
      name: segment.replace(/-/g, " ").toUpperCase(),
      path: index < pathArray.length - 1 ? path : null, // Last item is not a link
    };
  });
});
</script>
