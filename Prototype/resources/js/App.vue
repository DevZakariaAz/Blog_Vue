<script setup>
import { ref, computed, onMounted } from "vue";
import axios from "axios";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Dialog, DialogContent, DialogTitle, DialogHeader } from "@/components/ui/dialog";
// Import the translations
import translationsData from "./i18n/translations";

// State
const articles = ref([]);
const searchQuery = ref("");
const isModalOpen = ref(false);
const articleForm = ref({ id: null, title: "" });
const currentLanguage = ref('en'); // Default language
const translations = ref(translationsData); // Make translations reactive

// Translation helper function with error handling
const t = (key) => {
  try {
    if (!translations.value[currentLanguage.value]) {
      console.error(`Language ${currentLanguage.value} not found in translations`);
      return key;
    }
    const translation = translations.value[currentLanguage.value][key];
    if (!translation) {
      console.warn(`Translation key "${key}" not found for language ${currentLanguage.value}`);
      return key;
    }
    return translation;
  } catch (error) {
    console.error(`Translation error for key "${key}": ${error.message}`);
    return key;
  }
};

// Change language function
const changeLanguage = (lang) => {
  currentLanguage.value = lang;
};

// Fetch articles
const fetchArticles = async () => {
  try {
    const response = await axios.get("/api/articles");
    articles.value = response.data;
  } catch (error) {
    console.error("Error fetching articles", error);
  }
};

// Computed: Filtered articles
const filteredArticles = computed(() =>
  articles.value.filter((article) =>
    article.title.toLowerCase().includes(searchQuery.value.toLowerCase())
  )
);

// Open modal (for add/update)
const openModal = (article = null) => {
  if (article) {
    articleForm.value = { ...article }; // Edit mode
  } else {
    articleForm.value = { id: null, title: "" }; // Add mode
  }
  isModalOpen.value = true;
};

// Save article (add/update)
const saveArticle = async () => {
  try {
    if (articleForm.value.id) {
      await axios.put(`/api/articles/${articleForm.value.id}`, articleForm.value);
    } else {
      await axios.post("/api/articles", articleForm.value);
    }
    fetchArticles();
    isModalOpen.value = false;
  } catch (error) {
    console.error("Error saving article", error);
  }
};

// Delete article
const deleteArticle = async (id) => {
  try {
    await axios.delete(`/api/articles/${id}`);
    fetchArticles();
  } catch (error) {
    console.error("Error deleting article", error);
  }
};

// Export to CSV
const exportToCSV = () => {
  const csvContent =
    "data:text/csv;charset=utf-8," +
    "ID,Title\n" +
    articles.value.map((a) => `${a.id},${a.title}`).join("\n");

  const encodedUri = encodeURI(csvContent);
  const link = document.createElement("a");
  link.setAttribute("href", encodedUri);
  link.setAttribute("download", "articles.csv");
  document.body.appendChild(link);
  link.click();
};

// Import CSV - Make sure this function is properly defined
const fileInputRef = ref(null);

const importCSV = (event) => {
  const file = event.target.files?.[0];
  if (!file) return;

  const reader = new FileReader();
  reader.onload = async (e) => {
    const text = e.target.result;
    const rows = text.split("\n").slice(1); // Remove headers
    
    // Filter out empty rows
    const validRows = rows.filter(row => row.trim() !== '');
    
    const importedArticles = validRows.map((row) => {
      const [id, title] = row.split(",");
      return { id: id.trim(), title: title.trim() };
    });

    try {
      await axios.post("/api/articles/import", { articles: importedArticles });
      fetchArticles();
      // Reset the file input
      if (fileInputRef.value) {
        fileInputRef.value.value = '';
      }
    } catch (error) {
      console.error("Error importing CSV", error);
    }
  };
  reader.readAsText(file);
};

// Fetch on mount
onMounted(fetchArticles);
</script>

<template>
  <div class="container mx-auto p-4">
    <!-- Language Switcher -->
    <div class="flex justify-end mb-4">
      <Button @click="changeLanguage('en')" variant="outline" class="mr-2" 
        :class="{'bg-blue-100': currentLanguage === 'en'}">English</Button>
      <Button @click="changeLanguage('fr')" variant="outline"
        :class="{'bg-blue-100': currentLanguage === 'fr'}">Français</Button>
    </div>
    
    <!-- Search & Import/Export -->
    <div class="flex justify-between items-center mb-4">
      <Input v-model="searchQuery" :placeholder="t('search')" class="w-1/3" />
      <div class="flex gap-2">
        <input 
          type="file" 
          accept=".csv" 
          @change="importCSV" 
          class="hidden" 
          id="fileInput"
          ref="fileInputRef" 
        />
        <Button @click="() => document.getElementById('fileInput').click()">{{ t('import') }}</Button>
        <Button @click="exportToCSV()">{{ t('export') }}</Button>
        <Button @click="openModal()">{{ t('add') }}</Button>
      </div>
    </div>

    <!-- Articles Table -->
    <div class="bg-white shadow-md rounded-lg p-4">
      <table class="w-full border-collapse">
        <thead>
          <tr class="border-b">
            <th class="text-left p-2">{{ t('id') }}</th>
            <th class="text-left p-2">{{ t('title') }}</th>
            <th class="text-right p-2">{{ t('actions') }}</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="article in filteredArticles" :key="article.id" class="border-b">
            <td class="p-2">{{ article.id }}</td>
            <td class="p-2">{{ article.title }}</td>
            <td class="p-2 flex justify-end gap-2">
              <Button variant="outline" @click="openModal(article)">{{ t('edit') }}</Button>
              <Button variant="destructive" @click="deleteArticle(article.id)">{{ t('delete') }}</Button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Add/Edit Modal -->
    <Dialog v-model:open="isModalOpen">
      <DialogContent>
        <DialogHeader>
          <DialogTitle>{{ articleForm.id ? t('editArticle') : t('addArticle') }}</DialogTitle>
        </DialogHeader>
        <div>
          <Input v-model="articleForm.title" :placeholder="t('title')" class="w-full" />
          <div class="mt-4 flex justify-end gap-2">
            <Button variant="outline" @click="isModalOpen = false">{{ t('cancel') }}</Button>
            <Button @click="saveArticle">{{ t('save') }}</Button>
          </div>
        </div>
      </DialogContent>
    </Dialog>
  </div>
</template>