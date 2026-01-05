<template>
    <div class="popular-categories d-flex justify-content-center align-items-center flex-wrap gap-3 mb-5">
        <button @click="categoryId = null" :class="['category-tab', categoryId == null ? 'active' : '']">
            {{ $t('All') }}
        </button>

        <button v-for="(category, index) in featuredCategories" :key="category.id"
            @click="categoryId = category.id; pageNumber = 1;" :class="['category-tab', category.id == categoryId ? 'active' : '',
                index === featuredCategories.length - 1 ? 'last' : '']">
            {{ category.title }}
        </button>
    </div>

    <!-- Courses Grid -->
    <div class="row g-4">
        <div v-for="course in popularCourses" :key="course.id" class="col-12 col-md-6 col-lg-4 col-xl-3">
            <CourseCard :course="course" class="course-card" />
        </div>
    </div>

    <!-- Empty State -->
    <div v-if="popularCourses.length == 0" class="empty-state text-center my-5">
        <i class="ri-emotion-unhappy-line text-muted display-1 mb-3"></i>
        <h4 class="fw-semibold text-muted">{{ $t('No courses found') }}</h4>
    </div>

    <!-- Load More -->
    <div v-if="totalCourses > popularCourses.length" class="text-center">
        <button @click="loadMore" class="btn load-more-btn mt-4 px-5 fw-bold">
            {{ $t('Load More') }}
        </button>
    </div>

</template>

<style lang="scss" scoped>
.popular-categories {
    border: 1px solid var(--light-primary);
    padding: 15px 10px;
    border-radius: 10px;
    max-width: 100%;
    width: 60%;
    margin: 0 auto;
    overflow-x: auto;
    white-space: nowrap;
}

/* Hide scrollbar for Webkit browsers */
.popular-categories::-webkit-scrollbar {
    display: none;
}

/* Category Buttons */
.category-tab {
    background: none;
    border: none;
    color: #555;
    font-weight: 500;
    padding: 8px 12px;
    position: relative;
    font-size: 14px;
    transition: color 0.3s ease;
    display: inline-block;
    white-space: nowrap;
}

/* Separator line */
.category-tab:not(.last)::after {
    content: "|";
    color: #ccc;
    margin-left: 12px;
    position: absolute;
    right: -10px;
}

/* Active tab */
.category-tab.active {
    color: #b54dff;
    font-weight: 600;
}

/* Bottom underline for active */
.category-tab.active::before {
    content: "";
    position: absolute;
    left: 0;
    bottom: -4px;
    width: 100%;
    height: 2px;
    background: #b54dff;
    border-radius: 2px;
}

/* Responsive font & padding adjustments */
@media (max-width: 768px) {
    .popular-categories {
        width: 100%;
    }
    .category-tab {
        font-size: 13px;
        padding: 6px 10px;
    }
}

@media (max-width: 480px) {
    .category-tab {
        font-size: 12px;
        padding: 4px 8px;
    }
}
/* Course Cards Grid */
.course-card {
    transition: transform 0.25s ease, box-shadow 0.25s ease;
}

.course-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
}

/* Empty State */
.empty-state i {
    opacity: 0.5;
    font-size: 4rem;
}

.empty-state h4 {
    font-size: 1.2rem;
}

/* Load More Button */
.load-more-btn {
    background: linear-gradient(135deg, #b54dff, #9333ea);
    color: #fff;
    border: none;
    border-radius: 50px;
    padding: 12px 36px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(181, 77, 255, 0.3);
}

.load-more-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(181, 77, 255, 0.45);
}
</style>

<script setup>
import { ref, onMounted, watch } from "vue";
import axios from "axios";
import CourseCard from "./CourseCard.vue";
const categoryId = ref(null);
const popularCourses = ref([]);
const featuredCategories = ref([]);
const totalCourses = ref(0);

import { useAuthStore } from "@/stores/auth";

const authStore = useAuthStore();

let itemsPerPage = ref(8);

let loadMore = () => {
    itemsPerPage.value += 4;
    fetchPopularCourses();
};

// Fetch popular courses
const fetchPopularCourses = async (pageNumber = 1, push = false) => {
    try {
        const response = await axios.get(`/course/list`, {
            headers: {
                "Content-Type": "application/json",
                Accept: "application/json",
                Authorization: `Bearer ${authStore.authToken}`,
            },
            params: {
                items_per_page: itemsPerPage.value,
                page_number: pageNumber.value,
                category_id: categoryId.value,
                sort: "view_count",
                sortDirection: "desc",
            },
        });

        if (push) {
            popularCourses.value.push(...response.data.data.courses);
        } else {
            popularCourses.value = response.data.data.courses;
        }
        totalCourses.value = response.data.data.total_courses;
    } catch (error) {
        console.error("Error fetching popular courses:", error);
    }
};

// Fetch featured categories
const fetchFeaturedCategories = async () => {
    try {
        const response = await axios.get(`/categories`, {
            headers: {
                "Content-Type": "application/json",
                Accept: "application/json",
            },
            params: {
                is_featured: true,
                items_per_page: 6,
                page_number: 1,
            },
        });
        featuredCategories.value = response.data.data.categories;
    } catch (error) {
        console.error("Error fetching featured categories:", error);
    }
};

onMounted(() => {
    fetchPopularCourses();
    fetchFeaturedCategories();
});

watch(
    () => categoryId.value,
    () => {
        fetchPopularCourses();
    }
);
</script>
