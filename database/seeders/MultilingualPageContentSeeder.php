<?php

namespace Database\Seeders;

use App\Models\PageContent;
use Illuminate\Database\Seeder;

class MultilingualPageContentSeeder extends Seeder
{
    /**
     * Run the database seeders for multilingual content.
     *
     * This seeder adds translations to existing PageContent entries for:
     * - Spanish (es)
     * - French (fr)
     * - Portuguese (pt)
     * - Arabic (ar)
     */
    public function run()
    {
        $this->updateHomePageTranslations();
        $this->updateAboutPageTranslations();
        $this->updateContactPageTranslations();
        $this->updatePrayerRoomPageTranslations();
        $this->updateStreamPageTranslations();
        $this->updateRadioPageTranslations();
        $this->updateGroupsPageTranslations();
        $this->updateTestimoniesPageTranslations();
        $this->updateNewsPageTranslations();
        $this->updateEventsPageTranslations();
    }

    private function updateHomePageTranslations()
    {
        // Hero Section
        $this->updateContent('home', 'hero_title', [
            'title_es' => 'Red de Oración de Ministerios ISM',
            'subtitle_es' => 'Unidos en Oración, Fortalecidos en la Fe',
            'content_es' => 'Únete a una comunidad de creyentes comprometidos con la oración intercesora y el crecimiento espiritual.',
        ], [
            'title_fr' => 'Réseau de Prière des Ministères ISM',
            'subtitle_fr' => 'Unis dans la Prière, Fortifiés dans la Foi',
            'content_fr' => 'Rejoignez une communauté de croyants engagés dans la prière d\'intercession et la croissance spirituelle.',
        ], [
            'title_pt' => 'Rede de Oração dos Ministérios ISM',
            'subtitle_pt' => 'Unidos em Oração, Fortalecidos na Fé',
            'content_pt' => 'Junte-se a uma comunidade de crentes comprometidos com a oração intercessora e o crescimento espiritual.',
        ], [
            'title_ar' => 'شبكة صلاة وزارات ISM',
            'subtitle_ar' => 'متحدون في الصلاة، strengthening الإيمان',
            'content_ar' => 'انضم إلى مجتمع من المؤمنين الملتزمين بالصلاة الشفاعية والنمو الروحي.',
        ]);

        // Welcome Section
        $this->updateContent('home', 'welcome_title', [
            'title_es' => 'Bienvenido a la Red de Oración de Ministerios ISM',
            'content_es' => '<p>Somos una comunidad vibrante de ministros y creyentes dedicados al poder de la oración. Nuestra misión es unir a los cristianos de todo el mundo en oración intercesora, fomentando el crecimiento espiritual y la comunidad.</p><p>A través de nuestra plataforma en línea, puedes conectar con grupos de oración, compartir solicitudes de oración y experimentar el poder transformador de la oración colectiva.</p>',
        ], [
            'title_fr' => 'Bienvenue au Réseau de Prière des Ministères ISM',
            'content_fr' => '<p>Nous sommes une communauté vibrante de ministères et de croyants dédiés à la puissance de la prière. Notre mission est d\'unir les chrétiens du monde entier dans la prière d\'intercession, favorisant la croissance spirituelle et la communauté.</p><p> Grâce à notre plateforme en ligne, vous pouvez vous connecter avec des groupes de prière, partager des demandes de prière et expérimenter la puissance transformatrice de la prière collective.</p>',
        ], [
            'title_pt' => 'Bem-vindo à Rede de Oração dos Ministérios ISM',
            'content_pt' => '<p>Somos uma comunidade vibrante de ministros e crentes dedicados ao poder da oração. Nossa missão é unir os cristãos do mundo inteiro em oração intercessora, promovendo o crescimento espiritual e a comunidade.</p><p>Através de nossa plataforma online, você pode conectar-se com grupos de oração, compartilhar pedidos de oração e experimentar o poder transformador da oração coletiva.</p>',
        ], [
            'title_ar' => 'مرحباً بكم في شبكة صلاة وزارات ISM',
            'content_ar' => '<p>نحن مجتمع نابض بالحياة من القسوس والمؤمنين المكرسين لقوة الصلاة. مهمتنا هي توحيد المسيحيين حول العالم في الصلاة الشفاعية، وتعزيز النمو الروحي والمجتمع.</p><p>من خلال منصتنا عبر الإنترنت، يمكنك الاتصال بمجموعات الصلاة ومشاركة طلبات الصلاة وتجربة القوة التحويلية للصلاة الجماعية.</p>',
        ]);

        // Features Title
        $this->updateContent('home', 'features_title', [
            'title_es' => 'Nuestros Ministerios',
            'subtitle_es' => 'Descubre las formas en que servimos y crecemos juntos',
        ], [
            'title_fr' => 'Nos Ministères',
            'subtitle_fr' => 'Découvrez les façons dont nous servons et grandissons ensemble',
        ], [
            'title_pt' => 'Nossos Ministérios',
            'subtitle_pt' => 'Descubra as formas como servimos e crescemos juntos',
        ], [
            'title_ar' => 'وزاراتنا',
            'subtitle_ar' => 'اكتشف الطرق التي نخدم بها وننمو معاً',
        ]);

        // Feature: Prayer Groups
        $this->updateContent('home', 'feature_prayer_groups', [
            'title_es' => 'Grupos de Oración',
            'content_es' => 'Únete o crea grupos de oración para intercesión dirigida y construcción de comunidad.',
        ], [
            'title_fr' => 'Groupes de Prière',
            'content_fr' => 'Rejoignez ou créez des groupes de prière pour une intercession ciblée et la construction communautaire.',
        ], [
            'title_pt' => 'Grupos de Oração',
            'content_pt' => 'Junte-se ou crie grupos de oração para intercessão direcionada e construção comunitária.',
        ], [
            'title_ar' => 'مجموعات الصلاة',
            'content_ar' => 'انضم أو أنشئ مجموعات صلاة للشفاعة الموجهة وبناء المجتمع.',
        ]);

        // Feature: Resources
        $this->updateContent('home', 'feature_resources', [
            'title_es' => 'Recursos de Oración',
            'content_es' => 'Accede a guías, escrituras y herramientas para mejorar tu vida de oración.',
        ], [
            'title_fr' => 'Ressources de Prière',
            'content_fr' => 'Accédez à des guides, des écritures et des outils pour enrichir votre vie de prière.',
        ], [
            'title_pt' => 'Recursos de Oração',
            'content_pt' => 'Acesse guias, escrituras e ferramentas para enriquecer sua vida de oração.',
        ], [
            'title_ar' => 'موارد الصلاة',
            'content_ar' => 'احصل على أدلة وآيات كتابية وأدوات لإثراء حياتك الصلاة.',
        ]);

        // Feature: Events
        $this->updateContent('home', 'feature_events', [
            'title_es' => 'Eventos de Oración',
            'content_es' => 'Participa en sesiones de oración programadas y eventos de adoración.',
        ], [
            'title_fr' => 'Événements de Prière',
            'content_fr' => 'Participez à des sessions de prière programmées et des événements d\'adoration.',
        ], [
            'title_pt' => 'Eventos de Oração',
            'content_pt' => 'Participe de sessões de oração programadas e eventos de adoração.',
        ], [
            'title_ar' => 'أحداث الصلاة',
            'content_ar' => 'شارك في جلسات صلاة مقررة وأحداث عبادة.',
        ]);

        // CTA Section
        $this->updateContent('home', 'cta_title', [
            'title_es' => '¿Listo para Unirte a Nuestra Comunidad de Oración?',
            'content_es' => 'Da el primer paso hacia una vida de oración más profunda y conexiones significativas.',
        ], [
            'title_fr' => 'Prêt à Rejoindre Notre Communauté de Prière?',
            'content_fr' => 'Faites le premier pas vers une vie de prière plus profonde et des connexions significatives.',
        ], [
            'title_pt' => 'Pronto para se Juntar à Nossa Comunidade de Oração?',
            'content_pt' => 'Dê o primeiro passo para uma vida de oração mais profunda e conexões significativas.',
        ], [
            'title_ar' => 'هل أنت مستعد للانضمام إلى مجتمع الصلاة الخاص بنا؟',
            'content_ar' => 'اتخذ الخطوة الأولى نحو حياة صلاة أعمق واتصالات ذات معنى.',
        ]);
    }

    private function updateAboutPageTranslations()
    {
        // Hero Section
        $this->updateContent('about', 'hero_title', [
            'title_es' => 'Sobre Nosotros',
            'subtitle_es' => 'Nuestra Historia, Misión y Visión',
            'content_es' => 'Conoce más sobre la Red de Oración de Ministerios ISM y nuestro compromiso con la oración.',
        ], [
            'title_fr' => 'À Propos de Nous',
            'subtitle_fr' => 'Notre Histoire, Mission et Vision',
            'content_fr' => 'En savoir plus sur le Réseau de Prière des Ministères ISM et notre engagement envers la prière.',
        ], [
            'title_pt' => 'Sobre Nós',
            'subtitle_pt' => 'Nossa História, Missão e Visão',
            'content_pt' => 'Saiba mais sobre a Rede de Oração dos Ministérios ISM e nosso compromisso com a oração.',
        ], [
            'title_ar' => 'معلومات عنا',
            'subtitle_ar' => 'قصتنا، مهمتنا، ورؤيتنا',
            'content_ar' => 'تعرف أكثر على شبكة صلاة وزارات ISM والتزامنا بالصلاة.',
        ]);

        // Mission Section
        $this->updateContent('about', 'mission_title', [
            'title_es' => 'Nuestra Misión',
            'content_es' => '<p>Crear una red global de intercesores que buscan uniteadamente el rostro de Dios, elevando a la iglesia, naciones e individuos en oración.</p><p>Creemos en el poder transformador de la oración y nos esforzamos por equipar a los creyentes con recursos y comunidad para una intercesión efectiva.</p>',
        ], [
            'title_fr' => 'Notre Mission',
            'content_fr' => '<p>Créer un réseau global d\'intercesseurs qui cherchent ensemble le visage de Dieu, élevant l\'église, les nations et les individus dans la prière.</p><p>Nous croyons en la puissance transformatrice de la prière et nous nous efforçons d\'équiper les croyants de ressources et d\'une communauté pour une intercession efficace.</p>',
        ], [
            'title_pt' => 'Nossa Missão',
            'content_pt' => '<p>Criar uma rede global de intercessores que buscam unidamente o rosto de Deus, elevando a igreja, nações e indivíduos em oração.</p><p>Acreditamos no poder transformador da oração e nos esforçamos para equipar os crentes com recursos e comunidade para uma intercessão eficaz.</p>',
        ], [
            'title_ar' => 'مهمتنا',
            'content_ar' => '<p>إنشاء شبكة عالمية من الشفعاء الذين يبحثون معاً عن وجه الله، رافعين الكنيسة والأمم والأفراد في الصلاة.</p><p>نؤمن بقوة الصلاة التحويلية ونسعى لتزويد المؤمنين بالموارد والمجتمع من أجل شفاعة فعالة.</p>',
        ]);

        // Vision Section
        $this->updateContent('about', 'vision_title', [
            'title_es' => 'Nuestra Visión',
            'content_es' => '<p>Un mundo donde los cristianos están unidos en oración, donde las barreras se rompen, y donde la presencia de Dios transforma vidas y comunidades a través del ministerio de intercesión.</p>',
        ], [
            'title_fr' => 'Notre Vision',
            'content_fr' => '<p>Un monde où les chrétiens sont unis dans la prière, où les barrières sont brisées, et où la présence de Dieu transforme les vies et les communautés à travers le ministère d\'intercession.</p>',
        ], [
            'title_pt' => 'Nossa Visão',
            'content_pt' => '<p>Um mundo onde os cristãos estão unidos na oração, onde as barreiras são quebradas, e onde a presença de Deus transforma vidas e comunidades através do ministerio de intercessão.</p>',
        ], [
            'title_ar' => 'رؤيتنا',
            'content_ar' => '<p>عالم حيث Christians متحدون في الصلاة، حيث تنهار الحواجز، حيث يحول وجود الله حياة ومجتمعات من خلال خدمة الشفاعة.</p>',
        ]);

        // Values Title
        $this->updateContent('about', 'values_title', [
            'title_es' => 'Nuestros Valores Fundamentales',
        ], [
            'title_fr' => 'Nos Valeurs Fondamentales',
        ], [
            'title_pt' => 'Nossos Valores Fundamentais',
        ], [
            'title_ar' => 'قيمنا الأساسية',
        ]);

        // Value: Unity
        $this->updateContent('about', 'value_unity', [
            'title_es' => 'Unidad',
            'content_es' => 'Creemos en el poder de la oración unificada y la fuerza que viene cuando los creyentes oran juntos.',
        ], [
            'title_fr' => 'Unité',
            'content_fr' => 'Nous croyons en la puissance de la prière unifiée et la force qui vient quand les croyants prient ensemble.',
        ], [
            'title_pt' => 'Unidade',
            'content_pt' => 'Acreditamos no poder da oração unificada e a força que vem quando os crentes oram juntos.',
        ], [
            'title_ar' => 'الوحدة',
            'content_ar' => 'نؤمن بقوة الصلاة الموحدة والقوة التي تأتي عندما يصلي المؤمنون معاً.',
        ]);

        // Value: Faith
        $this->updateContent('about', 'value_faith', [
            'title_es' => 'Fe',
            'content_es' => 'Operamos en una fe inquebrantable, creyendo que Dios escucha y responde las oraciones según Su voluntad.',
        ], [
            'title_fr' => 'Foi',
            'content_fr' => 'Nous opérons dans une foi inébranlable, croyant que Dieu entend et répond aux prières selon Sa volonté.',
        ], [
            'title_pt' => 'Fé',
            'content_pt' => 'Operamos em uma fé inabalável, crendo que Deus ouve e responde às orações de acordo com Sua vontade.',
        ], [
            'title_ar' => 'الإيمان',
            'content_ar' => 'نعمل بإيمان راسخ، نؤمن أن الله يسمع ويستجيب للصلوات وفقاً لمشيئته.',
        ]);

        // Value: Love
        $this->updateContent('about', 'value_love', [
            'title_es' => 'Amor',
            'content_es' => 'Nos acercamos a la oración con corazones llenos de amor por Dios y los unos por los otros.',
        ], [
            'title_fr' => 'Amour',
            'content_fr' => 'Nous approchons la prière avec des cœurs remplis d\'amour pour Dieu et les uns pour les autres.',
        ], [
            'title_pt' => 'Amor',
            'content_pt' => 'Nos aproximamos da oração com coraçõescheios de amor por Deus e uns pelos outros.',
        ], [
            'title_ar' => 'المحبة',
            'content_ar' => 'نتقدم للصلاة بقلوب مليئة بالحب لله وللآخرين.',
        ]);
    }

    private function updateContactPageTranslations()
    {
        $this->updateContent('contact', 'hero_title', [
            'title_es' => 'Contáctenos',
            'subtitle_es' => 'Nos Encantaría Saber de Ti',
            'content_es' => 'Ponte en contacto con la Red de Oración de Ministerios ISM para consultas, solicitudes de oración o oportunidades de asociación.',
        ], [
            'title_fr' => 'Contactez-nous',
            'subtitle_fr' => 'Nous Serions Ravis d\'Entendre de Vous',
            'content_fr' => 'Contactez le Réseau de Prière des Ministères ISM pour des demandes de renseignements, des demandes de prière ou des opportunités de partenariat.',
        ], [
            'title_pt' => 'Contate-nos',
            'subtitle_pt' => 'Gostaríamos de Ouvir de Você',
            'content_pt' => 'Entre em contato com a Rede de Oração dos Ministérios ISM para consultas, pedidos de oração ou oportunidades de parceria.',
        ], [
            'title_ar' => 'اتصل بنا',
            'subtitle_ar' => 'يسرنا hearing منك',
            'content_ar' => 'تواصل مع شبكة صلاة وزارات ISM للاستفسارات وطلبات الصلاة أو فرص الشراكة.',
        ]);

        $this->updateContent('contact', 'form_title', [
            'title_es' => 'Envíanos un Mensaje',
            'content_es' => 'Completa el formulario a continuación y nos pondremos en contacto contigo lo antes posible.',
        ], [
            'title_fr' => 'Envoyez-nous un Message',
            'content_fr' => 'Remplissez le formulaire ci-dessous et nous vous répondrons dès que possible.',
        ], [
            'title_pt' => 'Envie-nos uma Mensagem',
            'content_pt' => 'Preencha o formulário abaixo e retornaremos o mais rápido possível.',
        ], [
            'title_ar' => 'أرسل لنا رسالة',
            'content_ar' => 'املأ النموذج أدناه وسنرد عليك في أقرب وقت ممكن.',
        ]);
    }

    private function updatePrayerRoomPageTranslations()
    {
        $this->updateContent('prayer-room', 'hero_title', [
            'title_es' => 'Sala de Oración',
            'subtitle_es' => 'Entra al espacio sagrado donde el cielo se encuentra con la tierra',
            'content_es' => 'Únete a nuestra sala de oración virtual para oración guiada, meditación de escritura y comunidad intercesora.',
        ], [
            'title_fr' => 'Salle de Prière',
            'subtitle_fr' => 'Entrez dans l\'espace sacré où le ciel rencontre la terre',
            'content_fr' => 'Rejoignez notre salle de prière virtuelle pour une prière guidée, une méditation des écritures et une communauté d\'intercession.',
        ], [
            'title_pt' => 'Sala de Oração',
            'subtitle_pt' => 'Entre no espaço sagrado onde o céu encontra a terra',
            'content_pt' => 'Junte-se à nossa sala de oração virtual para oração guiada, meditação das escrituras e comunidade intercessora.',
        ], [
            'title_ar' => 'غرفة الصلاة',
            'subtitle_ar' => 'أدخل الفضاء المقدس حيث يلتقي السماء بالأرض',
            'content_ar' => 'انضم إلى غرفة الصلاة الافتراضية الخاصة بنا للحصول على صلاة موجهة وتأمل في الكتاب المقدس ومجتمع الشفاعة.',
        ]);

        $this->updateContent('prayer-room', 'welcome_title', [
            'title_es' => 'Bienvenido a Nuestra Sala de Oración Virtual',
            'content_es' => '<p>Pasa a este santuario digital donde creyentes de todo el mundo se reúnen en espíritu para comunicarse con Dios. Aquí, la oración trasciende el tiempo y el espacio mientras unimos nuestros corazones en adoración, intercesión y acción de gracias.</p><p>Ya sea que busques paz, guía, sanación o simplemente desees acercarte más a Dios, esta sala de oración proporciona un espacio dedicado para intimidad con lo Divino.</p>',
        ], [
            'title_fr' => 'Bienvenue dans Notre Salle de Prière Virtuelle',
            'content_fr' => '<p>Entrez dans ce sanctuaire numérique où les croyants du monde entier se réunissent en esprit pour communier avec Dieu. Ici, la prière transcende le temps et l\'espace tandis que nous unissons nos cœurs dans l\'adoration, l\'intercession et l\'action de grâce.</p><p>Que vous cherchiez la paix, des conseils, la guérison ou simplement le désir de vous rapprocher de Dieu, cette salle de prière offre un espace dédié à l\'intimité avec le Divin.</p>',
        ], [
            'title_pt' => 'Bem-vindo à Nossa Sala de Oração Virtual',
            'content_pt' => '<p>Entre neste santuário digital onde crentes de todo o mundo se reúnem em espírito para comunicar-se com Deus. Aqui, a oração transcende o tempo e o espaço enquanto unimos nossos corações em adoração, intercessão e ação de graças.</p><p>Quer você busque paz, orientação, cura ou simplesmente deseje se aproximar mais de Deus, esta sala de oração oferece um espaço dedicado à intimidade com o Divino.</p>',
        ], [
            'title_ar' => 'مرحباً بكم في غرفة الصلاة الافتراضية الخاصة بنا',
            'content_ar' => '<p>ادخل إلى هذا الملاذ الرقمي حيث يجمع المؤمنون من حول العالم بالروح للتواصل مع الله. هنا، تتجاوز الصلاة الوقت والمساحة بينما نوحّد قلوبنا في العبادة والشفاعة والشكر.</p><p>سواء كنت تبحث عن السلام أو التوجيه أو الشفاء أو simplemente تسعى للتقرب أكثر من الله، توفر غرفة الصلاة هذه مساحة مخصصة للتواصل الحميم مع الإلهي.</p>',
        ]);

        $this->updateContent('prayer-room', 'features_title', [
            'title_es' => 'Características de la Sala de Oración',
            'subtitle_es' => 'Experimenta Momentos Sagrados',
        ], [
            'title_fr' => 'Caractéristiques de la Salle de Prière',
            'subtitle_fr' => 'Vivez des Moments Sacrés',
        ], [
            'title_pt' => 'Recursos da Sala de Oração',
            'subtitle_pt' => 'Experiência Momentos Sagrados',
        ], [
            'title_ar' => 'ميزات غرفة الصلاة',
            'subtitle_ar' => 'experiencia لحظات مقدسة',
        ]);
    }

    private function updateStreamPageTranslations()
    {
        $this->updateContent('stream', 'hero_title', [
            'title_es' => 'Transmisión en Vivo',
            'subtitle_es' => 'Observa eventos en vivo y grabaciones anteriores',
            'content_es' => 'Experimenta poderosas sesiones de adoración y enseñanza desde la comodidad de tu hogar.',
        ], [
            'title_fr' => 'Diffusion en Direct',
            'subtitle_fr' => 'Regardez des événements en direct et des enregistrements',
            'content_fr' => 'Découvrez de puissantes sessions d\'adoration et d\'enseignement depuis le confort de votre maison.',
        ], [
            'title_pt' => 'Transmissão ao Vivo',
            'subtitle_pt' => 'Assista eventos ao vivo e gravações',
            'content_pt' => 'Experimente sessões poderosas de adoração e ensino no conforto da sua casa.',
        ], [
            'title_ar' => 'البث المباشر',
            'subtitle_ar' => 'شاهد الأحداث المباشرة والتسجيلات',
            'content_ar' => 'جرب جلسات عبادة وتعليم قوية من راحة منزلك.',
        ]);
    }

    private function updateRadioPageTranslations()
    {
        $this->updateContent('radio', 'hero_title', [
            'title_es' => 'Radio de Oración ISM',
            'subtitle_es' => '24/7 orientación espiritual y transmisiones de oración',
            'content_es' => 'Sintoniza nuestra radio de oración 24/7 para adoración continua, enseñanza e intercesión.',
        ], [
            'title_fr' => 'Radio de Prière ISM',
            'subtitle_fr' => 'Guide spirituel et émissions de prière 24/7',
            'content_fr' => 'Écoutez notre radio de prière 24/7 pour une adoration continue, des enseignements et l\'intercession.',
        ], [
            'title_pt' => 'Rádio de Oração ISM',
            'subtitle_pt' => 'Orientação espiritual e transmissões de oração 24/7',
            'content_pt' => 'Sintonize nossa rádio de oração 24/7 para adoração contínua, ensinamentos e intercessão.',
        ], [
            'title_ar' => 'راديو صلاة ISM',
            'subtitle_ar' => 'توجيه روحي وبث صلاة على مدار الساعة',
            'content_ar' => 'اضبط راديو صلاة الخاص بنا للعبادة المستمرة والتعليم والشفاعة على مدار الساعة.',
        ]);

        $this->updateContent('radio', 'login_title', [
            'title_es' => 'Acceso Requerido',
            'content_es' => 'Por favor inicia sesión para acceder a nuestras transmisiones de radio de oración 24/7',
        ], [
            'title_fr' => 'Accès Requis',
            'content_fr' => 'Veuillez vous connecter pour accéder à nos émissions de radio de prière 24/7',
        ], [
            'title_pt' => 'Acesso Necessário',
            'content_pt' => 'Por favor, faça login para acessar nossas transmissões de rádio de oração 24/7',
        ], [
            'title_ar' => 'الوصول مطلوب',
            'content_ar' => 'الرجاء تسجيل الدخول للوصول إلى بث راديو الصلاة الخاص بنا على مدار الساعة',
        ]);
    }

    private function updateGroupsPageTranslations()
    {
        $this->updateContent('groups', 'hero_title', [
            'title_es' => 'Grupos de Oración',
            'subtitle_es' => 'Conecta, Ora y Crece Juntos',
            'content_es' => 'Encuentra o crea un grupo de oración en tu área y experimenta el poder de la oración unida.',
        ], [
            'title_fr' => 'Groupes de Prière',
            'subtitle_fr' => 'Connectez, Priez et Grandissez Ensemble',
            'content_fr' => 'Trouvez ou créez un groupe de prière dans votre région et expérimentez la puissance de la prière unie.',
        ], [
            'title_pt' => 'Grupos de Oração',
            'subtitle_pt' => 'Conecte, Ore e Cresça Juntos',
            'content_pt' => 'Encontre ou crie um grupo de oração na sua área e experimente o poder da oração unida.',
        ], [
            'title_ar' => 'مجموعات الصلاة',
            'subtitle_ar' => 'اتصل،صلِ،ونمُ معاً',
            'content_ar' => 'جد أو أنشئ مجموعة صلاة في منطقتك وجرب قوة الصلاة الموحدة.',
        ]);

        $this->updateContent('groups', 'features_title', [
            'title_es' => '¿Por Qué Unirte a un Grupo de Oración?',
        ], [
            'title_fr' => 'Pourquoi Rejoindre un Groupe de Prière?',
        ], [
            'title_pt' => 'Por Que Se Juntar a um Grupo de Oração?',
        ], [
            'title_ar' => 'لماذا تنضم إلى مجموعة صلاة؟',
        ]);
    }

    private function updateTestimoniesPageTranslations()
    {
        $this->updateContent('testimonies', 'hero_title', [
            'title_es' => 'Testimonios',
            'subtitle_es' => '¡Dios está Actuando!',
            'content_es' => 'Lee historias increíbles de cómo Dios está obrando a través de la oración en las vidas de los miembros de nuestra comunidad.',
        ], [
            'title_fr' => 'Témoignages',
            'subtitle_fr' => 'Dieu est à l\'œuvre!',
            'content_fr' => 'Lisez des histoires incroyables de la façon dont Dieu agit à travers la prière dans la vie des membres de notre communauté.',
        ], [
            'title_pt' => 'Testemunhos',
            'subtitle_pt' => 'Deus está Agindo!',
            'content_pt' => 'Leia histórias incríveis de como Deus está agindo através da oração na vida dos membros da nossa comunidade.',
        ], [
            'title_ar' => 'شهادات',
            'subtitle_ar' => 'الله يعمل!',
            'content_ar' => 'اقرأ قصص مذهلة عن كيف يعمل الله من خلال الصلاة في حياة أعضاء مجتمعنا.',
        ]);
    }

    private function updateNewsPageTranslations()
    {
        $this->updateContent('news', 'hero_title', [
            'title_es' => 'Noticias',
            'subtitle_es' => 'Mantente Informado',
            'content_es' => 'Últimas noticias y actualizaciones de ISM Ministers Prayer Network.',
        ], [
            'title_fr' => 'Nouvelles',
            'subtitle_fr' => 'Restez Informé',
            'content_fr' => 'Dernières nouvelles et mises à jour du Réseau de Prière des Ministères ISM.',
        ], [
            'title_pt' => 'Notícias',
            'subtitle_pt' => 'Fique Informado',
            'content_pt' => 'Últimas notícias e atualizações da Rede de Oração dos Ministérios ISM.',
        ], [
            'title_ar' => 'الأخبار',
            'subtitle_ar' => 'ابقَ على اطلاع',
            'content_ar' => 'أحدث الأخبار والتحديثات من شبكة صلاة وزارات ISM.',
        ]);
    }

    private function updateEventsPageTranslations()
    {
        $this->updateContent('events', 'hero_title', [
            'title_es' => 'Eventos',
            'subtitle_es' => 'Únete a Nosotros',
            'content_es' => 'Próximos eventos y programas de ISM Ministers Prayer Network.',
        ], [
            'title_fr' => 'Événements',
            'subtitle_fr' => 'Rejoignez-nous',
            'content_fr' => 'Prochains événements et programmes du Réseau de Prière des Ministères ISM.',
        ], [
            'title_pt' => 'Eventos',
            'subtitle_pt' => 'Junte-se a Nós',
            'content_pt' => 'Próximos eventos e programas da Rede de Oração dos Ministérios ISM.',
        ], [
            'title_ar' => 'الأحداث',
            'subtitle_ar' => 'انضم إلينا',
            'content_ar' => 'الأحداث والبرامج القادمة من شبكة صلاة وزارات ISM.',
        ]);
    }

    /**
     * Update a PageContent entry with translations
     */
    private function updateContent(string $page, string $key, array $es = [], array $fr = [], array $pt = [], array $ar = [])
    {
        $content = PageContent::where('page', $page)->where('key', $key)->first();

        if ($content) {
            $updates = [];

            // Spanish
            if (!empty($es)) {
                $updates = array_merge($updates, [
                    'title_es' => $es['title'] ?? null,
                    'subtitle_es' => $es['subtitle'] ?? null,
                    'content_es' => $es['content'] ?? null,
                ]);
            }

            // French
            if (!empty($fr)) {
                $updates = array_merge($updates, [
                    'title_fr' => $fr['title'] ?? null,
                    'subtitle_fr' => $fr['subtitle'] ?? null,
                    'content_fr' => $fr['content'] ?? null,
                ]);
            }

            // Portuguese
            if (!empty($pt)) {
                $updates = array_merge($updates, [
                    'title_pt' => $pt['title'] ?? null,
                    'subtitle_pt' => $pt['subtitle'] ?? null,
                    'content_pt' => $pt['content'] ?? null,
                ]);
            }

            // Arabic
            if (!empty($ar)) {
                $updates = array_merge($updates, [
                    'title_ar' => $ar['title'] ?? null,
                    'subtitle_ar' => $ar['subtitle'] ?? null,
                    'content_ar' => $ar['content'] ?? null,
                ]);
            }

            if (!empty($updates)) {
                $content->update($updates);
            }
        }
    }
}
