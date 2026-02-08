<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\TranslationLoader\LanguageLine;

class LanguageLinesSeeder extends Seeder
{
    /**
     * Run the database seeders for UI translations.
     *
     * This seeder populates the language_lines table with common UI translations
     * for buttons, labels, and messages in all supported languages.
     */
    public function run()
    {
        $this->createCommonTranslations();
        $this->createAuthTranslations();
        $this->createValidationTranslations();
        $this->createPaginationTranslations();
    }

    private function createCommonTranslations()
    {
        $translations = [
            // Navigation
            'nav.home' => [
                'en' => 'Home',
                'es' => 'Inicio',
                'fr' => 'Accueil',
                'pt' => 'Início',
                'ar' => 'الرئيسية',
            ],
            'nav.about' => [
                'en' => 'About',
                'es' => 'Sobre Nosotros',
                'fr' => 'À Propos',
                'pt' => 'Sobre',
                'ar' => 'معلومات عنا',
            ],
            'nav.prayer_room' => [
                'en' => 'Prayer Room',
                'es' => 'Sala de Oración',
                'fr' => 'Salle de Prière',
                'pt' => 'Sala de Oração',
                'ar' => 'غرفة الصلاة',
            ],
            'nav.stream' => [
                'en' => 'Live Stream',
                'es' => 'Transmisión en Vivo',
                'fr' => 'Diffusion en Direct',
                'pt' => 'Transmissão ao Vivo',
                'ar' => 'البث المباشر',
            ],
            'nav.radio' => [
                'en' => 'Prayer Radio',
                'es' => 'Radio de Oración',
                'fr' => 'Radio de Prière',
                'pt' => 'Rádio de Oração',
                'ar' => 'راديو الصلاة',
            ],
            'nav.groups' => [
                'en' => 'Prayer Groups',
                'es' => 'Grupos de Oración',
                'fr' => 'Groupes de Prière',
                'pt' => 'Grupos de Oração',
                'ar' => 'مجموعات الصلاة',
            ],
            'nav.testimonies' => [
                'en' => 'Testimonies',
                'es' => 'Testimonios',
                'fr' => 'Témoignages',
                'pt' => 'Testemunhos',
                'ar' => 'الشهادات',
            ],
            'nav.news' => [
                'en' => 'News',
                'es' => 'Noticias',
                'fr' => 'Nouvelles',
                'pt' => 'Notícias',
                'ar' => 'الأخبار',
            ],
            'nav.events' => [
                'en' => 'Events',
                'es' => 'Eventos',
                'fr' => 'Événements',
                'pt' => 'Eventos',
                'ar' => 'الأحداث',
            ],
            'nav.contact' => [
                'en' => 'Contact',
                'es' => 'Contacto',
                'fr' => 'Contact',
                'pt' => 'Contato',
                'ar' => 'اتصل بنا',
            ],
            'nav.login' => [
                'en' => 'Login',
                'es' => 'Iniciar Sesión',
                'fr' => 'Connexion',
                'pt' => 'Entrar',
                'ar' => 'تسجيل الدخول',
            ],
            'nav.register' => [
                'en' => 'Register',
                'es' => 'Registrarse',
                'fr' => 'S\'inscrire',
                'pt' => 'Cadastrar',
                'ar' => 'التسجيل',
            ],
            'nav.logout' => [
                'en' => 'Logout',
                'es' => 'Cerrar Sesión',
                'fr' => 'Déconnexion',
                'pt' => 'Sair',
                'ar' => 'تسجيل الخروج',
            ],
            'nav.dashboard' => [
                'en' => 'Dashboard',
                'es' => 'Panel',
                'fr' => 'Tableau de bord',
                'pt' => 'Painel',
                'ar' => 'لوحة التحكم',
            ],

            // Common Actions
            'common.read_more' => [
                'en' => 'Read More',
                'es' => 'Leer Más',
                'fr' => 'Lire la Suite',
                'pt' => 'Leia Mais',
                'ar' => 'اقرأ المزيد',
            ],
            'common.learn_more' => [
                'en' => 'Learn More',
                'es' => 'Más Información',
                'fr' => 'En Savoir Plus',
                'pt' => 'Saiba Mais',
                'ar' => 'اعرف المزيد',
            ],
            'common.view_all' => [
                'en' => 'View All',
                'es' => 'Ver Todo',
                'fr' => 'Voir Tout',
                'pt' => 'Ver Todos',
                'ar' => 'عرض الكل',
            ],
            'common.submit' => [
                'en' => 'Submit',
                'es' => 'Enviar',
                'fr' => 'Soumettre',
                'pt' => 'Enviar',
                'ar' => 'إرسال',
            ],
            'common.cancel' => [
                'en' => 'Cancel',
                'es' => 'Cancelar',
                'fr' => 'Annuler',
                'pt' => 'Cancelar',
                'ar' => 'إلغاء',
            ],
            'common.save' => [
                'en' => 'Save',
                'es' => 'Guardar',
                'fr' => 'Enregistrer',
                'pt' => 'Salvar',
                'ar' => 'حفظ',
            ],
            'common.delete' => [
                'en' => 'Delete',
                'es' => 'Eliminar',
                'fr' => 'Supprimer',
                'pt' => 'Excluir',
                'ar' => 'حذف',
            ],
            'common.edit' => [
                'en' => 'Edit',
                'es' => 'Editar',
                'fr' => 'Modifier',
                'pt' => 'Editar',
                'ar' => 'تعديل',
            ],
            'common.search' => [
                'en' => 'Search',
                'es' => 'Buscar',
                'fr' => 'Rechercher',
                'pt' => 'Buscar',
                'ar' => 'بحث',
            ],
            'common.back' => [
                'en' => 'Back',
                'es' => 'Volver',
                'fr' => 'Retour',
                'pt' => 'Voltar',
                'ar' => 'رجوع',
            ],
            'common.next' => [
                'en' => 'Next',
                'es' => 'Siguiente',
                'fr' => 'Suivant',
                'pt' => 'Próximo',
                'ar' => 'التالي',
            ],
            'common.previous' => [
                'en' => 'Previous',
                'es' => 'Anterior',
                'fr' => 'Précédent',
                'pt' => 'Anterior',
                'ar' => 'السابق',
            ],

            // Footer
            'footer.copyright' => [
                'en' => '© :year ISM Ministers Prayer Network. All rights reserved.',
                'es' => '© :year Red de Oración de Ministerios ISM. Todos los derechos reservados.',
                'fr' => '© :year Réseau de Prière des Ministères ISM. Tous droits réservés.',
                'pt' => '© :year Rede de Oração dos Ministérios ISM. Todos os direitos reservados.',
                'ar' => '© :year شبكة صلاة وزارات ISM. جميع الحقوق محفوظة.',
            ],
            'footer.privacy' => [
                'en' => 'Privacy Policy',
                'es' => 'Política de Privacidad',
                'fr' => 'Politique de Confidentialité',
                'pt' => 'Política de Privacidade',
                'ar' => 'سياسة الخصوصية',
            ],
            'footer.terms' => [
                'en' => 'Terms of Service',
                'es' => 'Términos de Servicio',
                'fr' => 'Conditions d\'Utilisation',
                'pt' => 'Termos de Serviço',
                'ar' => 'شروط الخدمة',
            ],

            // Messages
            'messages.success' => [
                'en' => 'Operation completed successfully.',
                'es' => 'Operación completada exitosamente.',
                'fr' => 'Opération terminée avec succès.',
                'pt' => 'Operação concluída com sucesso.',
                'ar' => 'اكتملت العملية بنجاح.',
            ],
            'messages.error' => [
                'en' => 'An error occurred. Please try again.',
                'es' => 'Ocurrió un error. Por favor intenta de nuevo.',
                'fr' => 'Une erreur s\'est produite. Veuillez réessayer.',
                'pt' => 'Ocorreu um erro. Por favor, tente novamente.',
                'ar' => 'حدث خطأ. يرجى المحاولة مرة أخرى.',
            ],
            'messages.loading' => [
                'en' => 'Loading...',
                'es' => 'Cargando...',
                'fr' => 'Chargement...',
                'pt' => 'Carregando...',
                'ar' => 'جاري التحميل...',
            ],
        ];

        foreach ($translations as $key => $texts) {
            $group = explode('.', $key)[0];
            $keyPart = explode('.', $key)[1];

            LanguageLine::updateOrCreate([
                'group' => $group,
                'key' => $keyPart,
            ], [
                'text' => $texts,
            ]);
        }
    }

    private function createAuthTranslations()
    {
        $translations = [
            'auth.login_title' => [
                'en' => 'Welcome Back',
                'es' => 'Bienvenido de Nuevo',
                'fr' => 'Bon Retour',
                'pt' => 'Bem-vindo de Volta',
                'ar' => 'مرحباً بعودتك',
            ],
            'auth.login_subtitle' => [
                'en' => 'Sign in to access your account',
                'es' => 'Inicia sesión para acceder a tu cuenta',
                'fr' => 'Connectez-vous pour accéder à votre compte',
                'pt' => 'Entre para acessar sua conta',
                'ar' => 'سجل الدخول للوصول إلى حسابك',
            ],
            'auth.register_title' => [
                'en' => 'Create Account',
                'es' => 'Crear Cuenta',
                'fr' => 'Créer un Compte',
                'pt' => 'Criar Conta',
                'ar' => 'إنشاء حساب',
            ],
            'auth.register_subtitle' => [
                'en' => 'Join our prayer community today',
                'es' => 'Únete a nuestra comunidad de oración hoy',
                'fr' => 'Rejoignez notre communauté de prière aujourd\'hui',
                'pt' => 'Junte-se à nossa comunidade de oração hoje',
                'ar' => 'انضم إلى مجتمع الصلاة الخاص بنا اليوم',
            ],
            'auth.email' => [
                'en' => 'Email Address',
                'es' => 'Correo Electrónico',
                'fr' => 'Adresse Email',
                'pt' => 'E-mail',
                'ar' => 'البريد الإلكتروني',
            ],
            'auth.password' => [
                'en' => 'Password',
                'es' => 'Contraseña',
                'fr' => 'Mot de Passe',
                'pt' => 'Senha',
                'ar' => 'كلمة المرور',
            ],
            'auth.confirm_password' => [
                'en' => 'Confirm Password',
                'es' => 'Confirmar Contraseña',
                'fr' => 'Confirmer le Mot de Passe',
                'pt' => 'Confirmar Senha',
                'ar' => 'تأكيد كلمة المرور',
            ],
            'auth.name' => [
                'en' => 'Full Name',
                'es' => 'Nombre Completo',
                'fr' => 'Nom Complet',
                'pt' => 'Nome Completo',
                'ar' => 'الاسم الكامل',
            ],
            'auth.remember' => [
                'en' => 'Remember Me',
                'es' => 'Recordarme',
                'fr' => 'Se Souvenir de Moi',
                'pt' => 'Lembrar-me',
                'ar' => 'تذكرني',
            ],
            'auth.forgot_password' => [
                'en' => 'Forgot Password?',
                'es' => '¿Olvidaste tu Contraseña?',
                'fr' => 'Mot de Passe Oublié?',
                'pt' => 'Esqueceu a Senha?',
                'ar' => 'نسيت كلمة المرور؟',
            ],
        ];

        foreach ($translations as $key => $texts) {
            $group = explode('.', $key)[0];
            $keyPart = explode('.', $key)[1];

            LanguageLine::updateOrCreate([
                'group' => $group,
                'key' => $keyPart,
            ], [
                'text' => $texts,
            ]);
        }
    }

    private function createValidationTranslations()
    {
        $translations = [
            'validation.required' => [
                'en' => 'This field is required.',
                'es' => 'Este campo es obligatorio.',
                'fr' => 'Ce champ est obligatoire.',
                'pt' => 'Este campo é obrigatório.',
                'ar' => 'هذا الحقل مطلوب.',
            ],
            'validation.email' => [
                'en' => 'Please enter a valid email address.',
                'es' => 'Por favor ingresa un correo electrónico válido.',
                'fr' => 'Veuillez entrer une adresse email valide.',
                'pt' => 'Por favor, insira um e-mail válido.',
                'ar' => 'يرجى إدخال بريد إلكتروني صالح.',
            ],
            'validation.min' => [
                'en' => 'The :attribute must be at least :min characters.',
                'es' => 'El :attribute debe tener al menos :min caracteres.',
                'fr' => 'Le :attribute doit contenir au moins :min caractères.',
                'pt' => 'O :attribute deve ter pelo menos :min caracteres.',
                'ar' => 'يجب أن يكون :attribute على الأقل :min أحرف.',
            ],
            'validation.confirmed' => [
                'en' => 'The :attribute confirmation does not match.',
                'es' => 'La confirmación de :attribute no coincide.',
                'fr' => 'La confirmation de :attribute ne correspond pas.',
                'pt' => 'A confirmação de :attribute não coincide.',
                'ar' => 'تأكيد :attribute لا يتطابق.',
            ],
        ];

        foreach ($translations as $key => $texts) {
            $group = explode('.', $key)[0];
            $keyPart = explode('.', $key)[1];

            LanguageLine::updateOrCreate([
                'group' => $group,
                'key' => $keyPart,
            ], [
                'text' => $texts,
            ]);
        }
    }

    private function createPaginationTranslations()
    {
        $translations = [
            'pagination.previous' => [
                'en' => 'Previous',
                'es' => 'Anterior',
                'fr' => 'Précédent',
                'pt' => 'Anterior',
                'ar' => 'السابق',
            ],
            'pagination.next' => [
                'en' => 'Next',
                'es' => 'Siguiente',
                'fr' => 'Suivant',
                'pt' => 'Próximo',
                'ar' => 'التالي',
            ],
            'pagination.leading' => [
                'en' => 'Showing :first to :last of :total results',
                'es' => 'Mostrando :first a :last de :total resultados',
                'fr' => 'Affichage de :first à :last sur :total résultats',
                'pt' => 'Mostrando :first a :last de :total resultados',
                'ar' => 'عرض :first إلى :last من :total نتائج',
            ],
        ];

        foreach ($translations as $key => $texts) {
            $group = explode('.', $key)[0];
            $keyPart = explode('.', $key)[1];

            LanguageLine::updateOrCreate([
                'group' => $group,
                'key' => $keyPart,
            ], [
                'text' => $texts,
            ]);
        }
    }
}
