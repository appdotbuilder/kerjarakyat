import React from 'react';
import AppLayout from '@/layouts/app-layout';
import { Head, Link } from '@inertiajs/react';
import { Button } from '@/components/ui/button';
import { type BreadcrumbItem } from '@/types';

interface User {
    id: number;
    name: string;
    email: string;
    role: string;
    city?: {
        name: string;
    };
}

interface Worker {
    id: number;
    skillCategory: {
        name: string;
    };
    skillLevel: {
        name: string;
    };
    rating: number;
    totalJobs: number;
    certificationStatus: string;
}

interface JobRequest {
    id: number;
    title: string;
    status: string;
    skillCategory: {
        name: string;
    };
    city: {
        name: string;
    };
    user?: {
        name: string;
    };
    worker?: {
        user: {
            name: string;
        };
    };
    createdAt: string;
}

interface Stats {
    totalJobs?: number;
    completedJobs: number;
    activeJobs: number;
    rating?: number;
    totalReviews?: number;
    pendingJobs?: number;
}

interface Props {
    user: User;
    worker?: Worker;
    availableJobs?: JobRequest[];
    myJobs?: JobRequest[];
    nearbyWorkers?: Array<{
        id: number;
        user: {
            name: string;
        };
        skillCategory: {
            name: string;
        };
        skillLevel: {
            name: string;
        };
        rating: number;
        totalJobs: number;
    }>;
    stats: Stats;
    [key: string]: unknown;
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

export default function Dashboard({ user, worker, availableJobs, myJobs, nearbyWorkers, stats }: Props) {
    const isWorker = user.role === 'worker';

    const getStatusBadge = (status: string) => {
        const statusMap = {
            open: { color: 'bg-green-100 text-green-800', text: '🟢 Terbuka', emoji: '🟢' },
            survey_requested: { color: 'bg-yellow-100 text-yellow-800', text: '📋 Survey Diminta', emoji: '📋' },
            survey_scheduled: { color: 'bg-blue-100 text-blue-800', text: '📅 Survey Dijadwalkan', emoji: '📅' },
            estimated: { color: 'bg-purple-100 text-purple-800', text: '💰 Menunggu Persetujuan', emoji: '💰' },
            approved: { color: 'bg-indigo-100 text-indigo-800', text: '✅ Disetujui', emoji: '✅' },
            in_progress: { color: 'bg-orange-100 text-orange-800', text: '🚧 Sedang Dikerjakan', emoji: '🚧' },
            completed: { color: 'bg-green-100 text-green-800', text: '✅ Selesai', emoji: '✅' },
            cancelled: { color: 'bg-red-100 text-red-800', text: '❌ Dibatalkan', emoji: '❌' },
        };
        
        const statusInfo = statusMap[status as keyof typeof statusMap] || statusMap.open;
        
        return (
            <span className={`inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${statusInfo.color}`}>
                {statusInfo.text}
            </span>
        );
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Dashboard" />
            
            <div className="p-6">
                {/* Welcome Header */}
                <div className="mb-8">
                    <h1 className="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                        Selamat datang, {user.name}! 👋
                    </h1>
                    <p className="text-gray-600 dark:text-gray-300">
                        {isWorker 
                            ? '🔨 Dashboard tukang - kelola profil dan pekerjaan Anda'
                            : '🏠 Dashboard klien - temukan tukang terbaik untuk proyek Anda'
                        }
                    </p>
                </div>

                {/* Stats Cards */}
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div className="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                        <div className="p-5">
                            <div className="flex items-center">
                                <div className="flex-shrink-0">
                                    <div className="text-2xl">📊</div>
                                </div>
                                <div className="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt className="text-sm font-medium text-gray-500 dark:text-gray-300 truncate">
                                            {isWorker ? 'Total Pekerjaan' : 'Total Permintaan'}
                                        </dt>
                                        <dd className="text-lg font-medium text-gray-900 dark:text-white">
                                            {stats.totalJobs || stats.completedJobs + stats.activeJobs + (stats.pendingJobs || 0)}
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div className="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                        <div className="p-5">
                            <div className="flex items-center">
                                <div className="flex-shrink-0">
                                    <div className="text-2xl">✅</div>
                                </div>
                                <div className="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt className="text-sm font-medium text-gray-500 dark:text-gray-300 truncate">
                                            Selesai
                                        </dt>
                                        <dd className="text-lg font-medium text-gray-900 dark:text-white">
                                            {stats.completedJobs}
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div className="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                        <div className="p-5">
                            <div className="flex items-center">
                                <div className="flex-shrink-0">
                                    <div className="text-2xl">🚧</div>
                                </div>
                                <div className="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt className="text-sm font-medium text-gray-500 dark:text-gray-300 truncate">
                                            Aktif
                                        </dt>
                                        <dd className="text-lg font-medium text-gray-900 dark:text-white">
                                            {stats.activeJobs}
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div className="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                        <div className="p-5">
                            <div className="flex items-center">
                                <div className="flex-shrink-0">
                                    <div className="text-2xl">⭐</div>
                                </div>
                                <div className="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt className="text-sm font-medium text-gray-500 dark:text-gray-300 truncate">
                                            {isWorker ? 'Rating' : 'Menunggu'}
                                        </dt>
                                        <dd className="text-lg font-medium text-gray-900 dark:text-white">
                                            {isWorker ? `${stats.rating}/5.0` : stats.pendingJobs || 0}
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {/* Worker Specific Content */}
                {isWorker && worker && (
                    <div className="grid lg:grid-cols-2 gap-8 mb-8">
                        {/* Worker Profile Summary */}
                        <div className="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                            <h3 className="text-lg font-medium text-gray-900 dark:text-white mb-4">
                                📋 Profil Tukang
                            </h3>
                            <div className="space-y-3">
                                <div>
                                    <span className="text-sm font-medium text-gray-500 dark:text-gray-300">Keahlian:</span>
                                    <span className="ml-2 text-sm text-gray-900 dark:text-white">{worker.skillCategory.name}</span>
                                </div>
                                <div>
                                    <span className="text-sm font-medium text-gray-500 dark:text-gray-300">Level:</span>
                                    <span className="ml-2 text-sm text-gray-900 dark:text-white">{worker.skillLevel.name}</span>
                                </div>
                                <div>
                                    <span className="text-sm font-medium text-gray-500 dark:text-gray-300">Status Sertifikat:</span>
                                    <span className={`ml-2 px-2 py-1 rounded-full text-xs font-medium ${
                                        worker.certificationStatus === 'certified' 
                                            ? 'bg-green-100 text-green-800' 
                                            : 'bg-yellow-100 text-yellow-800'
                                    }`}>
                                        {worker.certificationStatus === 'certified' ? '✅ Tersertifikasi' : '🕒 Proses Sertifikasi'}
                                    </span>
                                </div>
                                <div className="pt-4">
                                    <Link href={route('workers.edit', worker.id)}>
                                        <Button className="bg-blue-600 hover:bg-blue-700">
                                            ✏️ Edit Profil
                                        </Button>
                                    </Link>
                                </div>
                            </div>
                        </div>

                        {/* Available Jobs */}
                        <div className="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                            <div className="flex justify-between items-center mb-4">
                                <h3 className="text-lg font-medium text-gray-900 dark:text-white">
                                    🎯 Pekerjaan Tersedia
                                </h3>
                                <Link href={route('job-requests.index')}>
                                    <Button variant="outline" size="sm">
                                        Lihat Semua
                                    </Button>
                                </Link>
                            </div>
                            <div className="space-y-3">
                                {availableJobs?.slice(0, 3).map((job) => (
                                    <div key={job.id} className="border dark:border-gray-700 rounded-lg p-3">
                                        <h4 className="font-medium text-sm text-gray-900 dark:text-white mb-1">
                                            {job.title}
                                        </h4>
                                        <p className="text-xs text-gray-500 dark:text-gray-400 mb-2">
                                            📍 {job.city.name} • 🔧 {job.skillCategory.name}
                                        </p>
                                        <div className="flex justify-between items-center">
                                            {getStatusBadge(job.status)}
                                            <Link href={route('job-requests.show', job.id)}>
                                                <Button size="sm" variant="outline">
                                                    Lihat
                                                </Button>
                                            </Link>
                                        </div>
                                    </div>
                                ))}
                                {(!availableJobs || availableJobs.length === 0) && (
                                    <p className="text-center text-gray-500 dark:text-gray-400 py-4">
                                        Tidak ada pekerjaan tersedia saat ini
                                    </p>
                                )}
                            </div>
                        </div>
                    </div>
                )}

                {/* Client Specific Content */}
                {!isWorker && (
                    <div className="grid lg:grid-cols-2 gap-8 mb-8">
                        {/* My Job Requests */}
                        <div className="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                            <div className="flex justify-between items-center mb-4">
                                <h3 className="text-lg font-medium text-gray-900 dark:text-white">
                                    📋 Permintaan Pekerjaan Saya
                                </h3>
                                <Link href={route('job-requests.create')}>
                                    <Button className="bg-green-600 hover:bg-green-700">
                                        ➕ Buat Permintaan
                                    </Button>
                                </Link>
                            </div>
                            <div className="space-y-3">
                                {myJobs?.slice(0, 3).map((job) => (
                                    <div key={job.id} className="border dark:border-gray-700 rounded-lg p-3">
                                        <h4 className="font-medium text-sm text-gray-900 dark:text-white mb-1">
                                            {job.title}
                                        </h4>
                                        <p className="text-xs text-gray-500 dark:text-gray-400 mb-2">
                                            📍 {job.city.name} • 🔧 {job.skillCategory.name}
                                            {job.worker && (
                                                <span> • 👷‍♂️ {job.worker.user.name}</span>
                                            )}
                                        </p>
                                        <div className="flex justify-between items-center">
                                            {getStatusBadge(job.status)}
                                            <Link href={route('job-requests.show', job.id)}>
                                                <Button size="sm" variant="outline">
                                                    Lihat
                                                </Button>
                                            </Link>
                                        </div>
                                    </div>
                                ))}
                                {(!myJobs || myJobs.length === 0) && (
                                    <p className="text-center text-gray-500 dark:text-gray-400 py-4">
                                        Belum ada permintaan pekerjaan
                                    </p>
                                )}
                            </div>
                        </div>

                        {/* Nearby Workers */}
                        <div className="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                            <div className="flex justify-between items-center mb-4">
                                <h3 className="text-lg font-medium text-gray-900 dark:text-white">
                                    👷‍♂️ Tukang Terdekat
                                </h3>
                                <Link href={route('workers.index')}>
                                    <Button variant="outline" size="sm">
                                        Lihat Semua
                                    </Button>
                                </Link>
                            </div>
                            <div className="space-y-3">
                                {nearbyWorkers?.slice(0, 3).map((worker) => (
                                    <div key={worker.id} className="border dark:border-gray-700 rounded-lg p-3">
                                        <div className="flex justify-between items-start mb-2">
                                            <h4 className="font-medium text-sm text-gray-900 dark:text-white">
                                                {worker.user.name}
                                            </h4>
                                            <div className="flex items-center space-x-1 text-xs">
                                                <span className="text-yellow-400">⭐</span>
                                                <span>{worker.rating}</span>
                                            </div>
                                        </div>
                                        <p className="text-xs text-gray-500 dark:text-gray-400 mb-2">
                                            🔧 {worker.skillCategory.name} • 📊 {worker.skillLevel.name}
                                        </p>
                                        <div className="flex justify-between items-center">
                                            <span className="text-xs text-gray-500 dark:text-gray-400">
                                                {worker.totalJobs} pekerjaan selesai
                                            </span>
                                            <Link href={route('workers.show', worker.id)}>
                                                <Button size="sm" variant="outline">
                                                    Lihat
                                                </Button>
                                            </Link>
                                        </div>
                                    </div>
                                ))}
                                {(!nearbyWorkers || nearbyWorkers.length === 0) && (
                                    <p className="text-center text-gray-500 dark:text-gray-400 py-4">
                                        Tidak ada tukang di kota Anda
                                    </p>
                                )}
                            </div>
                        </div>
                    </div>
                )}

                {/* Quick Actions */}
                <div className="bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg p-8 text-white">
                    <h3 className="text-2xl font-bold mb-4">
                        {isWorker ? '🚀 Tingkatkan Profil Anda' : '🎯 Mulai Proyek Baru'}
                    </h3>
                    <p className="mb-6 opacity-90">
                        {isWorker 
                            ? 'Lengkapi profil dan dapatkan sertifikasi untuk mendapat lebih banyak pekerjaan!'
                            : 'Temukan tukang terbaik untuk proyek Anda dengan sistem matching yang akurat.'
                        }
                    </p>
                    <div className="flex flex-col sm:flex-row gap-4">
                        {isWorker ? (
                            <>
                                <Link href={route('workers.edit', worker?.id || '')}>
                                    <Button className="bg-white text-blue-600 hover:bg-gray-100">
                                        📝 Lengkapi Profil
                                    </Button>
                                </Link>
                                <Link href={route('job-requests.index')}>
                                    <Button variant="outline" className="border-white text-white hover:bg-white hover:text-blue-600">
                                        🔍 Cari Pekerjaan
                                    </Button>
                                </Link>
                            </>
                        ) : (
                            <>
                                <Link href={route('job-requests.create')}>
                                    <Button className="bg-white text-blue-600 hover:bg-gray-100">
                                        ➕ Buat Permintaan Pekerjaan
                                    </Button>
                                </Link>
                                <Link href={route('workers.index')}>
                                    <Button variant="outline" className="border-white text-white hover:bg-white hover:text-blue-600">
                                        👷‍♂️ Cari Tukang
                                    </Button>
                                </Link>
                            </>
                        )}
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}