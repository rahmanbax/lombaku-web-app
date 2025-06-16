<style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Navbar Minimalis */
        .minimal-navbar {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            padding: 1.2rem 2rem;
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo-section {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo-icon {
            width: 36px;
            height: 36px;
            background-color: #000;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo-icon i {
            color: white;
            font-size: 18px;
        }

        .logo-text {
            font-size: 1.5rem;
            font-weight: 600;
            color: #000;
            letter-spacing: -0.5px;
        }

        .nav-items {
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .nav-link {
            color: #333;
            font-size: 1rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s ease;
            position: relative;
            padding: 0.5rem 0;
        }

        .nav-link:hover {
            color: #000;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background-color: #000;
            transition: width 0.3s ease;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .dropdown {
            position: relative;
        }

        .dropdown-toggle {
            background: none;
            border: none;
            cursor: pointer;
            color: #333;
            font-size: 1rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 0.5rem 0;
        }

        .dropdown-icon {
            font-size: 0.8rem;
            transition: transform 0.3s ease;
        }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0;
            background: white;
            min-width: 200px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            border-radius: 8px;
            padding: 0.5rem 0;
            margin-top: 0.5rem;
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: all 0.3s ease;
            z-index: 100;
        }

        .dropdown:hover .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown:hover .dropdown-icon {
            transform: rotate(180deg);
        }

        .dropdown-item {
            display: block;
            padding: 0.7rem 1.5rem;
            color: #333;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .dropdown-item:hover {
            background-color: #f5f5f5;
            color: #000;
        }

        .login-btn {
            background-color: #000;
            color: white;
            border: none;
            border-radius: 6px;
            padding: 0.7rem 1.5rem;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .login-btn:hover {
            background-color: #333;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.08);
        }

        .hamburger {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #000;
        }

        /* Hero Section */
        .hero {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 3rem 1rem;
            text-align: center;
            background-color: white;
            margin: 2rem;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.03);
        }

        .hero h1 {
            font-size: 2.8rem;
            font-weight: 700;
            color: #000;
            margin-bottom: 1.5rem;
            max-width: 700px;
            line-height: 1.2;
        }

        .hero p {
            font-size: 1.1rem;
            color: #555;
            max-width: 600px;
            line-height: 1.7;
            margin-bottom: 2rem;
        }

        .divider {
            height: 1px;
            background: linear-gradient(to right, transparent, #ddd, transparent);
            margin: 3rem auto;
            width: 80%;
            max-width: 500px;
        }

        /* Search Bar Styles */
        .search-container {
            position: relative;
            max-width: 650px;
            width: 100%;
            margin: 0 auto 2rem;
        }

        .search-input {
            width: 100%;
            padding: 16px 25px;
            font-size: 1.1rem;
            border: 2px solid #e0e0e0;
            border-radius: 60px;
            outline: none;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            padding-right: 70px;
        }

        .search-input:focus {
            border-color: #3498db;
            box-shadow: 0 5px 20px rgba(52, 152, 219, 0.2);
        }

        .search-button {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            width: 45px;
            height: 45px;
            background: #2c3e50;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .search-button:hover {
            background: #3498db;
            transform: translateY(-50%) scale(1.05);
        }

        .search-button i {
            color: white;
            font-size: 1.2rem;
        }

        .feature-list {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            max-width: 500px;
            margin: 0 auto;
            gap: 12px;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #555;
            font-size: 1.05rem;
        }

        .feature-item i {
            color: #000;
            font-size: 1.1rem;
        }

        /* Footer Styles */
        .footer {
            background-color: #000;
            color: white;
            padding: 3rem 2rem;
            text-align: center;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto 2rem;
            padding: 0 1rem;
        }

        .footer-text {
            font-size: 1.4rem;
            font-weight: 600;
            margin-bottom: 2rem;
            line-height: 1.5;
        }

        .admin-btn {
            background-color: white;
            color: #000;
            border: none;
            border-radius: 6px;
            padding: 1rem 2.5rem;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(255, 255, 255, 0.15);
        }

        .admin-btn:hover {
            background-color: #f0f0f0;
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(255, 255, 255, 0.25);
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 1.5rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .copyright {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
        }

        /* Card Styles */
        .card-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 2rem;
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        .card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .card-image {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }

        .card-date {
            padding: 0.5rem 1.5rem;
            color: #777;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .card-content {
            padding: 1rem 1.5rem 1.5rem;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
            color: #000;
        }

        .card-description {
            color: #555;
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 1.25rem;
        }

        .card-button {
            display: inline-block;
            background-color: #000;
            color: white;
            padding: 0.6rem 1.2rem;
            border-radius: 6px;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }

        .card-button:hover {
            background-color: #333;
        }

        /* Responsive Cards */
        @media (max-width: 768px) {
            .card-container {
                grid-template-columns: 1fr;
                max-width: 400px;
            }

            .card-image {
                height: 200px;
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hamburger {
                display: block;
            }

            .nav-items {
                position: fixed;
                top: 0;
                right: -100%;
                width: 280px;
                height: 100vh;
                background: white;
                flex-direction: column;
                align-items: flex-start;
                padding: 2rem;
                gap: 1.5rem;
                box-shadow: -5px 0 15px rgba(0, 0, 0, 0.05);
                transition: right 0.4s ease;
                z-index: 1000;
            }

            .nav-items.active {
                right: 0;
            }

            .dropdown-menu {
                position: static;
                box-shadow: none;
                margin: 0.5rem 0 0 1rem;
                display: none;
            }

            .dropdown.active .dropdown-menu {
                display: block;
                opacity: 1;
                visibility: visible;
                transform: none;
            }

            .hero h1 {
                font-size: 2.2rem;
            }

            .search-input {
                padding: 14px 20px;
                padding-right: 60px;
            }

            .search-button {
                width: 40px;
                height: 40px;
            }

            .footer {
                padding: 2rem 1rem;
            }

            .footer-text {
                font-size: 1.2rem;
            }

            .admin-btn {
                padding: 0.9rem 2rem;
                font-size: 1rem;
            }
        }
        /* Tambahan style untuk dropdown user */
        .user-dropdown .dropdown-toggle {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 2px;
        }
        
        .user-name {
            font-weight: 600;
            color: #000;
        }
        
        .user-role {
            font-size: 0.8rem;
            color: #777;
            font-weight: 500;
        }
        
        .dropdown-menu .user-info {
            padding: 0.7rem 1.5rem;
            border-bottom: 1px solid #eee;
        }
        
        .dropdown-menu .logout-btn {
            display: block;
            width: 100%;
            padding: 0.7rem 1.5rem;
            background: none;
            border: none;
            text-align: left;
            color: #333;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .dropdown-menu .logout-btn:hover {
            background-color: #f5f5f5;
            color: #000;
        }
        
        /* Perbaikan responsif */
        @media (max-width: 768px) {
            .user-dropdown .dropdown-toggle {
                flex-direction: row;
                align-items: center;
                gap: 8px;
            }
            
            .user-name {
                font-size: 0.95rem;
            }
        }
    </style>