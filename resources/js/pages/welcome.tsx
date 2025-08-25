import { type SharedData } from '@/types';
import { Head, Link, usePage } from '@inertiajs/react';

export default function Welcome() {
    const { auth } = usePage<SharedData>().props;

    return (
        <>
            <Head title="KerjaRakyat - Platform Pemberdayaan Tukang Indonesia">
                <link rel="preconnect" href="https://fonts.bunny.net" />
                <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
            </Head>
            <div className="min-h-screen bg-gradient-to-b from-blue-50 to-white dark:from-gray-900 dark:to-gray-800">
                {/* Header */}
                <header className="bg-white shadow-sm dark:bg-gray-900">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                        <div className="flex justify-between items-center">
                            <div className="flex items-center space-x-2">
                                <div className="text-2xl">🔨</div>
                                <h1 className="text-2xl font-bold text-blue-600 dark:text-blue-400">KerjaRakyat</h1>
                            </div>
                            <nav className="flex items-center space-x-4">
                                {auth.user ? (
                                    <Link
                                        href={route('dashboard')}
                                        className="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-colors"
                                    >
                                        Dashboard
                                    </Link>
                                ) : (
                                    <>
                                        <Link
                                            href={route('login')}
                                            className="text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white font-medium"
                                        >
                                            Masuk
                                        </Link>
                                        <Link
                                            href={route('register')}
                                            className="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-colors"
                                        >
                                            Daftar Sekarang
                                        </Link>
                                    </>
                                )}
                            </nav>
                        </div>
                    </div>
                </header>

                {/* Hero Section */}
                <main className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                    <div className="text-center mb-16">
                        <h2 className="text-4xl md:text-6xl font-bold text-gray-900 dark:text-white mb-6">
                            🏗️ Platform Digital untuk <br />
                            <span className="text-blue-600 dark:text-blue-400">Tukang Indonesia</span>
                        </h2>
                        <p className="text-xl text-gray-600 dark:text-gray-300 mb-8 max-w-3xl mx-auto">
                            Sistem pemberdayaan dan perlindungan tenaga kerja informal yang menghubungkan
                            tukang bersertifikat dengan klien. Transparan, aman, dan terpercaya.
                        </p>
                        {!auth.user && (
                            <div className="flex flex-col sm:flex-row gap-4 justify-center">
                                <Link
                                    href={route('register')}
                                    className="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-lg font-semibold text-lg transition-colors inline-flex items-center justify-center space-x-2"
                                >
                                    <span>👷‍♂️</span>
                                    <span>Daftar Sebagai Tukang</span>
                                </Link>
                                <Link
                                    href={route('register')}
                                    className="bg-green-600 hover:bg-green-700 text-white px-8 py-4 rounded-lg font-semibold text-lg transition-colors inline-flex items-center justify-center space-x-2"
                                >
                                    <span>🏠</span>
                                    <span>Cari Tukang</span>
                                </Link>
                            </div>
                        )}
                    </div>

                    {/* Features Grid */}
                    <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
                        <div className="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-lg">
                            <div className="text-4xl mb-4">📋</div>
                            <h3 className="text-xl font-semibold text-gray-900 dark:text-white mb-3">
                                Sertifikasi Tukang
                            </h3>
                            <p className="text-gray-600 dark:text-gray-300">
                                Sistem sertifikasi melalui BLK terdekat dengan pencatatan nomor sertifikat
                                dan level keahlian yang terverifikasi.
                            </p>
                        </div>

                        <div className="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-lg">
                            <div className="text-4xl mb-4">🔍</div>
                            <h3 className="text-xl font-semibold text-gray-900 dark:text-white mb-3">
                                Pencarian Tukang
                            </h3>
                            <p className="text-gray-600 dark:text-gray-300">
                                Cari tukang berdasarkan lokasi terdekat, keahlian spesifik,
                                dan rating dari klien sebelumnya.
                            </p>
                        </div>

                        <div className="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-lg">
                            <div className="text-4xl mb-4">📊</div>
                            <h3 className="text-xl font-semibold text-gray-900 dark:text-white mb-3">
                                Estimasi Transparan
                            </h3>
                            <p className="text-gray-600 dark:text-gray-300">
                                Perhitungan otomatis biaya berdasarkan UMK, level keahlian,
                                BPJS, dan komisi aplikasi.
                            </p>
                        </div>

                        <div className="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-lg">
                            <div className="text-4xl mb-4">📄</div>
                            <h3 className="text-xl font-semibold text-gray-900 dark:text-white mb-3">
                                Kontrak Digital
                            </h3>
                            <p className="text-gray-600 dark:text-gray-300">
                                Surat kontrak pekerjaan otomatis dalam format PDF
                                setelah estimasi disetujui kedua belah pihak.
                            </p>
                        </div>

                        <div className="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-lg">
                            <div className="text-4xl mb-4">💳</div>
                            <h3 className="text-xl font-semibold text-gray-900 dark:text-white mb-3">
                                Pembayaran Aman
                            </h3>
                            <p className="text-gray-600 dark:text-gray-300">
                                Sistem pembayaran panjar 50%, dompet digital,
                                transfer bank, atau tunai dengan pencatatan lengkap.
                            </p>
                        </div>

                        <div className="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-lg">
                            <div className="text-4xl mb-4">🛡️</div>
                            <h3 className="text-xl font-semibold text-gray-900 dark:text-white mb-3">
                                Perlindungan Sosial
                            </h3>
                            <p className="text-gray-600 dark:text-gray-300">
                                Pencatatan internal untuk manfaat BPJS Kesehatan
                                dan Ketenagakerjaan yang terintegrasi.
                            </p>
                        </div>
                    </div>

                    {/* Stats Section */}
                    <div className="bg-blue-600 dark:bg-blue-800 text-white rounded-xl p-8 mb-16">
                        <div className="grid md:grid-cols-4 gap-8 text-center">
                            <div>
                                <div className="text-3xl font-bold mb-2">1000+</div>
                                <div className="text-blue-200">Tukang Terdaftar</div>
                            </div>
                            <div>
                                <div className="text-3xl font-bold mb-2">500+</div>
                                <div className="text-blue-200">Proyek Selesai</div>
                            </div>
                            <div>
                                <div className="text-3xl font-bold mb-2">4.8/5</div>
                                <div className="text-blue-200">Rating Rata-rata</div>
                            </div>
                            <div>
                                <div className="text-3xl font-bold mb-2">10+</div>
                                <div className="text-blue-200">Kategori Keahlian</div>
                            </div>
                        </div>
                    </div>

                    {/* Skill Categories */}
                    <div className="text-center mb-16">
                        <h3 className="text-3xl font-bold text-gray-900 dark:text-white mb-8">
                            🔧 Kategori Keahlian Tersedia
                        </h3>
                        <div className="grid grid-cols-2 md:grid-cols-5 gap-4">
                            {[
                                { icon: '🪚', name: 'Tukang Kayu' },
                                { icon: '⚡', name: 'Tukang Listrik' },
                                { icon: '🚰', name: 'Tukang Ledeng' },
                                { icon: '🧱', name: 'Tukang Batu' },
                                { icon: '🎨', name: 'Tukang Cat' },
                                { icon: '🔧', name: 'Tukang Besi' },
                                { icon: '🏠', name: 'Tukang Genteng' },
                                { icon: '🔳', name: 'Tukang Keramik' },
                                { icon: '❄️', name: 'Tukang AC' },
                                { icon: '🌱', name: 'Tukang Kebun' },
                            ].map((skill) => (
                                <div
                                    key={skill.name}
                                    className="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md text-center"
                                >
                                    <div className="text-2xl mb-2">{skill.icon}</div>
                                    <div className="text-sm font-medium text-gray-900 dark:text-white">
                                        {skill.name}
                                    </div>
                                </div>
                            ))}
                        </div>
                    </div>

                    {/* CTA Section */}
                    {!auth.user && (
                        <div className="bg-gray-50 dark:bg-gray-800 rounded-xl p-12 text-center">
                            <h3 className="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                                Siap Bergabung dengan KerjaRakyat? 🚀
                            </h3>
                            <p className="text-gray-600 dark:text-gray-300 mb-8 max-w-2xl mx-auto">
                                Mulai perjalanan Anda sebagai tukang profesional atau temukan
                                tukang terpercaya untuk proyek Anda hari ini.
                            </p>
                            <div className="flex flex-col sm:flex-row gap-4 justify-center">
                                <Link
                                    href={route('register')}
                                    className="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-lg font-semibold transition-colors inline-flex items-center justify-center space-x-2"
                                >
                                    <span>📝</span>
                                    <span>Daftar Gratis Sekarang</span>
                                </Link>
                                <Link
                                    href={route('login')}
                                    className="border border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white px-8 py-4 rounded-lg font-semibold transition-colors inline-flex items-center justify-center space-x-2"
                                >
                                    <span>🔐</span>
                                    <span>Sudah Punya Akun? Masuk</span>
                                </Link>
                            </div>
                        </div>
                    )}
                </main>

                {/* Footer */}
                <footer className="bg-gray-900 text-white py-12">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div className="grid md:grid-cols-4 gap-8">
                            <div className="col-span-2">
                                <div className="flex items-center space-x-2 mb-4">
                                    <div className="text-2xl">🔨</div>
                                    <h3 className="text-xl font-bold">KerjaRakyat</h3>
                                </div>
                                <p className="text-gray-300 mb-4">
                                    Platform digital untuk pemberdayaan dan perlindungan
                                    tenaga kerja informal Indonesia.
                                </p>
                                <p className="text-sm text-gray-400">
                                    © 2024 KerjaRakyat. Semua hak dilindungi.
                                </p>
                            </div>
                            <div>
                                <h4 className="font-semibold mb-4">Platform</h4>
                                <ul className="space-y-2 text-gray-300">
                                    <li>Cara Kerja</li>
                                    <li>Sertifikasi</li>
                                    <li>Keamanan</li>
                                    <li>Bantuan</li>
                                </ul>
                            </div>
                            <div>
                                <h4 className="font-semibold mb-4">Kontak</h4>
                                <ul className="space-y-2 text-gray-300">
                                    <li>📧 info@kerjarakyat.id</li>
                                    <li>📱 0800-1234-5678</li>
                                    <li>📍 Jakarta, Indonesia</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </>
    );
}