<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // ---- PERMISSIONS ----
        $permissions = [
            // Surat
            'surat.view_all', 'surat.verify', 'surat.approve', 'surat.reject', 'surat.print',
            // Pengaduan
            'pengaduan.view_all', 'pengaduan.process', 'pengaduan.close', 'pengaduan.reassign',
            // Users
            'users.view', 'users.create', 'users.edit', 'users.delete',
            // Roles
            'roles.view', 'roles.manage',
            // Content (existing)
            'articles.manage', 'announcements.manage', 'gallery.manage',
            'faqs.manage', 'documents.manage', 'statistics.manage',
            // Media
            'media.upload', 'media.delete',
            // Settings
            'settings.manage',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm, 'guard_name' => 'web']);
        }

        // ---- ROLES ----
        $roleMap = [
            'super_admin' => Permission::all()->pluck('name')->toArray(),

            'kepala_desa' => [
                'surat.view_all', 'surat.approve', 'surat.reject', 'surat.print',
                'pengaduan.view_all', 'pengaduan.close',
                'users.view', 'roles.view',
                'articles.manage', 'announcements.manage',
            ],

            'sekretaris_desa' => [
                'surat.view_all', 'surat.approve', 'surat.reject', 'surat.print',
                'pengaduan.view_all', 'pengaduan.process',
                'users.view',
                'articles.manage', 'announcements.manage', 'faqs.manage', 'documents.manage',
            ],

            'kasi' => [
                'surat.view_all', 'surat.approve', 'surat.reject', 'surat.print',
                'pengaduan.view_all', 'pengaduan.process',
                'articles.manage', 'announcements.manage',
            ],

            'kaur' => [
                'surat.view_all', 'surat.print',
                'pengaduan.view_all',
                'statistics.manage',
            ],

            'operator' => [
                'surat.view_all', 'surat.verify', 'surat.print',
                'pengaduan.view_all', 'pengaduan.process',
                'media.upload',
            ],

            'petugas_pelayanan' => [
                'surat.view_all', 'surat.verify',
                'pengaduan.view_all', 'pengaduan.process',
            ],

            'bumdes' => [
                'articles.manage',
            ],

            'rt' => [
                'surat.view_all',
                'pengaduan.view_all',
            ],

            'rw' => [
                'surat.view_all',
                'pengaduan.view_all',
            ],

            'warga' => [],
        ];

        foreach ($roleMap as $roleName => $rolePermissions) {
            $role = Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
            $role->syncPermissions($rolePermissions);
            $this->command->info("✅ Role: {$roleName} (" . count($rolePermissions) . " permissions)");
        }

        $this->command->info('✅ RolePermissionSeeder selesai.');
    }
}
