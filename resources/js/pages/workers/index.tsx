import React from 'react';
import AppLayout from '@/layouts/app-layout';
import { Head, Link, router } from '@inertiajs/react';
import { Button } from '@/components/ui/button';

interface Worker {
    id: number;
    user: {
        name: string;
        city: {
            name: string;
        } | null;
    };
    skillCategory: {
        name: string;
    };
    skillLevel: {
        name: string;
    };
    rating: number;
    totalJobs: number;
    bio: string | null;
    certificationStatus: string;
}

interface SkillCategory {
    id: number;
    name: string;
}

interface City {
    id: number;
    name: string;
}

interface Props {
    workers: {
        data: Worker[];
        links: Array<{
            url: string | null;
            label: string;
            active: boolean;
        }>;
        current_page: number;
        last_page: number;
    };
    skillCategories: SkillCategory[];
    cities: City[];
    filters: {
        skill_category?: string;
        city_id?: string;
        sort?: string;
    };
    [key: string]: unknown;
}

export default function WorkersIndex({ workers, skillCategories, cities, filters }: Props) {
    const handleFilter = (field: string, value: string) => {
        router.get(route('workers.index'), {
            ...filters,
            [field]: value,
        }, {
            preserveState: true,
            preserveScroll: true,
        });
    };

    return (
        <AppLayout>
            <Head title="Daftar Tukang" />
            
            <div className="container mx-auto px-4 py-8">
                <div className="flex justify-between items-center mb-8">
                    <h1 className="text-3xl font-bold text-gray-900 dark:text-white">
                        🔨 Daftar Tukang Bersertifikat
                    </h1>
                    <Link href={route('workers.create')}>
                        <Button className="bg-blue-600 hover:bg-blue-700">
                            👷‍♂️ Daftar Sebagai Tukang
                        </Button>
                    </Link>
                </div>

                {/* Filters */}
                <div className="grid md:grid-cols-3 gap-4 mb-8 p-6 bg-white dark:bg-gray-800 rounded-lg shadow">
                    <div>
                        <label className="block text-sm font-medium mb-2">Kategori Keahlian</label>
                        <select
                            value={filters.skill_category || ''}
                            onChange={(e) => handleFilter('skill_category', e.target.value)}
                            className="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                        >
                            <option value="">Semua Kategori</option>
                            {skillCategories.map((category) => (
                                <option key={category.id} value={category.id.toString()}>
                                    {category.name}
                                </option>
                            ))}
                        </select>
                    </div>

                    <div>
                        <label className="block text-sm font-medium mb-2">Kota</label>
                        <select
                            value={filters.city_id || ''}
                            onChange={(e) => handleFilter('city_id', e.target.value)}
                            className="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                        >
                            <option value="">Semua Kota</option>
                            {cities.map((city) => (
                                <option key={city.id} value={city.id.toString()}>
                                    {city.name}
                                </option>
                            ))}
                        </select>
                    </div>

                    <div>
                        <label className="block text-sm font-medium mb-2">Urutkan</label>
                        <select
                            value={filters.sort || ''}
                            onChange={(e) => handleFilter('sort', e.target.value)}
                            className="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                        >
                            <option value="">Default</option>
                            <option value="rating">Rating Tertinggi</option>
                            <option value="jobs">Pekerjaan Terbanyak</option>
                        </select>
                    </div>
                </div>

                {/* Workers Grid */}
                <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    {workers.data.map((worker) => (
                        <div key={worker.id} className="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                            <div className="p-6">
                                <div className="flex items-center justify-between mb-4">
                                    <h3 className="text-xl font-semibold text-gray-900 dark:text-white">
                                        {worker.user.name}
                                    </h3>
                                    <span className={`px-2 py-1 rounded-full text-xs font-medium ${
                                        worker.certificationStatus === 'certified' 
                                            ? 'bg-green-100 text-green-800' 
                                            : 'bg-yellow-100 text-yellow-800'
                                    }`}>
                                        {worker.certificationStatus === 'certified' ? '✅ Tersertifikasi' : '🕒 Proses'}
                                    </span>
                                </div>

                                <div className="space-y-2 mb-4">
                                    <p className="text-sm text-gray-600 dark:text-gray-300">
                                        <span className="font-medium">Keahlian:</span> {worker.skillCategory.name}
                                    </p>
                                    <p className="text-sm text-gray-600 dark:text-gray-300">
                                        <span className="font-medium">Level:</span> {worker.skillLevel.name}
                                    </p>
                                    <p className="text-sm text-gray-600 dark:text-gray-300">
                                        <span className="font-medium">Lokasi:</span> {worker.user.city?.name || 'Tidak diset'}
                                    </p>
                                </div>

                                <div className="flex items-center justify-between mb-4">
                                    <div className="flex items-center space-x-1">
                                        <span className="text-yellow-400">⭐</span>
                                        <span className="text-sm font-medium">{worker.rating}/5.0</span>
                                        <span className="text-xs text-gray-500">({worker.totalJobs} pekerjaan)</span>
                                    </div>
                                </div>

                                {worker.bio && (
                                    <p className="text-sm text-gray-600 dark:text-gray-300 mb-4 line-clamp-2">
                                        {worker.bio}
                                    </p>
                                )}

                                <Link href={route('workers.show', worker.id)}>
                                    <Button className="w-full bg-blue-600 hover:bg-blue-700">
                                        Lihat Profil Lengkap
                                    </Button>
                                </Link>
                            </div>
                        </div>
                    ))}
                </div>

                {/* Pagination */}
                {workers.last_page > 1 && (
                    <div className="flex justify-center space-x-2">
                        {workers.links.map((link, index) => (
                            <button
                                key={index}
                                onClick={() => {
                                    if (link.url) {
                                        router.get(link.url, {}, { preserveState: true });
                                    }
                                }}
                                disabled={!link.url}
                                className={`px-4 py-2 rounded-md text-sm font-medium ${
                                    link.active
                                        ? 'bg-blue-600 text-white'
                                        : link.url
                                        ? 'bg-white text-gray-700 border border-gray-300 hover:bg-gray-50'
                                        : 'bg-gray-100 text-gray-400 cursor-not-allowed'
                                }`}
                            >
                                <span dangerouslySetInnerHTML={{ __html: link.label }} />
                            </button>
                        ))}
                    </div>
                )}

                {workers.data.length === 0 && (
                    <div className="text-center py-12">
                        <div className="text-6xl mb-4">🔍</div>
                        <h3 className="text-xl font-medium text-gray-900 dark:text-white mb-2">
                            Tidak ada tukang ditemukan
                        </h3>
                        <p className="text-gray-600 dark:text-gray-300">
                            Coba ubah filter pencarian atau coba lagi nanti.
                        </p>
                    </div>
                )}
            </div>
        </AppLayout>
    );
}