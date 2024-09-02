import { ref, onMounted, computed } from "vue";
import { useForm, usePage } from "@inertiajs/vue3";
import axios from "axios";
export function useArticles() {
    const articles = ref([]);
    const modalShown = ref(false);
    const limit = ref(5);

    const page = usePage();
    const user = computed(() => page.props.auth.user);

    const form = useForm({
        user_id: "",
        slug: "",
        title: "",
        content: "",
    });

    const fetchArticles = async () => {
        const request = await axios.get("/api/articles");
        articles.value = request.data;
    };

    const handleArticles = async () => {
        const request = await axios.get(`/api/articles?limit=${limit.value}`);
        articles.value = request.data;
    };

    const editArticle = (article) => {
        handleModal();

        form.slug = article.slug;
        form.title = article.title;
        form.content = article.content;
    };

    const deleteArticle = async (article) => {
        if (confirm("Are you sure to delete this article?")) {
            try {
                const req = axios.delete(`/api/articles/${article.slug}`);
                const res = await req;
                await fetchArticles();
            } catch (e) {
                console.error(e);
            }
        }
    };

    const handleModal = () => {
        clearFormData();
        form.user_id = user.value.id;
        modalShown.value = !modalShown.value;
    };

    const clearFormData = () => {
        form.slug = null;
        form.title = "";
        form.content = "";
    };

    const handleStoreRequest = async () => {
        try {
            const req = axios.post("/api/articles", form.data());
            const res = await req;

            if (res.status === 201) {
                clearFormData();
                handleModal();
                await fetchArticles();
            }
        } catch (e) {
            console.log(e.response.data);
        }
    };

    const handleUpdateRequest = async () => {
        try {
            const req = axios.put(`/api/articles/${form.slug}`, form.data());
            const res = await req;

            console.log("Create response:", res.data);
            clearFormData();
            handleModal();
            await fetchArticles();
        } catch (e) {
            console.error(e);
        }
    };
    const submit = async () => {
        if (!form.slug) {
            await handleStoreRequest();
        } else {
            await handleUpdateRequest();
        }
    };

    onMounted(fetchArticles);

    return {
        handleModal,
        modalShown,
        articles,
        fetchArticles,
        submit,
        form,
        user,
        editArticle,
        deleteArticle,
        limit,
        handleArticles,
    };
}
