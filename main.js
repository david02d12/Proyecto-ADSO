// === Simulacro de Base de Datos (Arrays de Objetos) ===
        const users = [
            { id: 1, email: 'cliente', password: '123', role: 'cliente', name: 'Cliente Ejemplo' },
            { id: 2, email: 'tecnico', password: '123', role: 'tecnico', name: 'Técnico Andrés' },
            { id: 3, email: 'admin', password: '123', role: 'admin', name: 'Admin Claudia' }
        ];

        let products = [
            { id: 1, name: 'Cargador Rápido USB-C', description: 'Carga tu dispositivo al 50% en 30 minutos.', price: 29, img: 'https://placehold.co/400x400/dc2626/ffffff?text=Cargador' },
            { id: 2, name: 'Funda de Silicona', description: 'Protección ligera y suave para tu móvil.', price: 15, img: 'https://placehold.co/400x400/dc2626/ffffff?text=Funda' },
            { id: 3, name: 'Vidrio Templado 9H', description: 'Defensa máxima contra rasguños y golpes.', price: 10, img: 'https://placehold.co/400x400/dc2626/ffffff?text=Vidrio' },
            { id: 4, name: 'Batería Externa 10000mAh', description: 'Carga tu móvil hasta 3 veces fuera de casa.', price: 45, img: 'https://placehold.co/400x400/dc2626/ffffff?text=Bateria' }
        ];
        
        let inventory = [
            { id: 1, name: 'Pantalla iPhone 13', stock: 15 },
            { id: 2, name: 'Batería Galaxy S22', stock: 20 },
            { id: 3, name: 'Cámara Xiaomi 12', stock: 12 },
            { id: 4, name: 'Puerto carga USB-C', stock: 35 }
        ];

        let services = [
            { id: 1, userId: 1, device: 'iPhone X', description: 'Pantalla rota', status: 'en-progreso', technicianId: 2, diagnostic: 'Reemplazo de pantalla.', rating: null, comments: null },
            { id: 2, userId: 1, device: 'Samsung S10', description: 'No carga', status: 'completado', technicianId: 2, diagnostic: 'Cambio de puerto de carga.', rating: 4, comments: 'Excelente servicio, muy rápido.' },
            { id: 3, userId: 1, device: 'Xiaomi Mi 9', description: 'Se apaga solo', status: 'pendiente', technicianId: null, diagnostic: null, rating: null, comments: null }
        ];

        const chats = [
            { id: 1, serviceId: 1, messages: [{ sender: 'cliente', text: 'Hola, ¿cómo va el progreso?' }, { sender: 'tecnico', text: 'Hola. El diagnóstico está completo, ya estamos reemplazando la pieza.' }] },
            { id: 2, serviceId: 2, messages: [{ sender: 'cliente', text: 'Gracias por la reparación, ¡quedó perfecto!' }, { sender: 'tecnico', text: 'Me alegra saberlo, ¡estamos para servirte!' }] }
        ];

        const notifications = [
            { role: 'cliente', text: 'Tu solicitud para iPhone X está En Progreso.' },
            { role: 'tecnico', text: 'Tienes una nueva solicitud de servicio pendiente.' },
            { role: 'admin', text: 'El inventario de "Pantalla iPhone 13" está bajo.' }
        ];

        let currentUser = null;
        let activeService = null;
        const app = document.getElementById('app');

        // === Funciones de renderizado ===
        function renderHeader() {
            return `
                <div class="header">
                    <h1>Celuaccel</h1>
                    <div id="auth-info">
                        ${currentUser ? `<span>Hola, ${currentUser.name}</span> <button onclick="handleLogout()">Cerrar Sesión</button>` : `<button onclick="showLoginModal()">Iniciar Sesión</button>`}
                    </div>
                </div>
            `;
        }

        function renderPublicCatalog() {
            return `
                <div class="main-content container">
                    <h2>Catálogo de Productos</h2>
                    <p>Conoce los últimos accesorios que ofrecemos.</p>
                    <div class="catalog-grid">
                        ${products.map(p => `
                            <div class="card">
                                <img src="${p.img}" alt="${p.name}">
                                <h3>${p.name}</h3>
                                <p>${p.description}</p>
                                <p><strong>$${p.price}</strong></p>
                            </div>
                        `).join('')}
                    </div>
                </div>
            `;
        }
        
        function renderLoginModal() {
            return `
                <div id="login-modal" class="modal">
                    <div class="modal-content">
                        <span class="modal-close" onclick="closeModal('login-modal')">&times;</span>
                        <h2>Iniciar Sesión</h2>
                        <div class="alert-box hidden" id="login-error">Credenciales incorrectas. Inténtalo de nuevo.</div>
                        <form onsubmit="handleLogin(event)">
                            <div class="form-group">
                                <label for="email">Usuario:</label>
                                <input type="text" id="email" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Contraseña:</label>
                                <input type="password" id="password" name="password" required>
                            </div>
                            <p class="text-sm">
                                <strong>Credenciales de prueba:</strong><br>
                                Usuario: cliente, tecnico o admin<br>
                                Contraseña: 123
                            </p>
                            <button type="submit" class="btn">Acceder</button>
                        </form>
                    </div>
                </div>
            `;
        }

        function renderClientDashboard() {
            activeService = services.find(s => s.userId === currentUser.id);

            const statusMap = {
                'pendiente': '0%',
                'en-progreso': '50%',
                'completado': '100%'
            };
            const statusTextMap = {
                'pendiente': 'Pendiente',
                'en-progreso': 'En Progreso',
                'completado': 'Completado'
            };

            let serviceProgress = '';
            if (activeService) {
                serviceProgress = `
                    <h3>Mi Servicio Activo: ${activeService.device}</h3>
                    <p>Estado actual: <strong>${statusTextMap[activeService.status]}</strong></p>
                    <div class="progress-bar-container">
                        <div class="progress-bar ${activeService.status}" style="width: ${statusMap[activeService.status]};"></div>
                    </div>
                `;
                if (activeService.diagnostic) {
                    serviceProgress += `<p>Diagnóstico: <em>${activeService.diagnostic}</em></p>`;
                }
            } else {
                serviceProgress = `
                    <p>No tienes servicios activos. Puedes solicitar uno nuevo.</p>
                `;
            }

            let chatInterface = '';
            const chat = chats.find(c => c.serviceId === (activeService ? activeService.id : null));
            if (chat) {
                chatInterface = `
                    <div class="chat-container">
                        <h3>Chat con Técnico</h3>
                        <div class="chat-messages" id="chat-messages">
                            ${chat.messages.map(m => `
                                <div class="chat-message ${m.sender === 'cliente' ? 'me' : 'other'}">
                                    ${m.text}
                                </div>
                            `).join('')}
                        </div>
                        <div class="chat-input">
                            <input type="text" id="chat-input" placeholder="Escribe un mensaje...">
                            <button class="btn" onclick="sendMessage()">Enviar</button>
                        </div>
                    </div>
                `;
            }

            let ratingForm = '';
            if (activeService && activeService.status === 'completado' && activeService.rating === null) {
                ratingForm = `
                    <h3>Calificar Servicio</h3>
                    <div class="star-rating-container" id="star-rating-container">
                        ${[1, 2, 3, 4, 5].map(i => `<span class="star-rating" data-rating="${i}" onmouseover="highlightStars(this)" onmouseout="resetStars(this)" onclick="rateService(${i})">&#9733;</span>`).join('')}
                    </div>
                    <form onsubmit="submitComment(event)">
                        <div class="form-group">
                            <label for="comment">Comentarios:</label>
                            <textarea id="comment" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn">Enviar Comentario</button>
                    </form>
                `;
            } else if (activeService && activeService.status === 'completado' && activeService.rating !== null) {
                ratingForm = `
                    <h3>Servicio Calificado</h3>
                    <p>Tu calificación: 
                        ${[1, 2, 3, 4, 5].map(i => `<span class="star-rating ${i <= activeService.rating ? 'active' : ''}">&#9733;</span>`).join('')}
                    </p>
                    <p>Comentarios: <em>${activeService.comments}</em></p>
                `;
            }

            return `
                <div class="dashboard-container">
                    <div class="sidebar">
                        <h2>Menú Cliente</h2>
                        <a href="#" onclick="showSection('private-catalog')">Catálogo Privado</a>
                        <a href="#" onclick="showSection('service-request')">Solicitar Servicio</a>
                        <a href="#" onclick="showSection('service-status')">Estado del Servicio</a>
                        <a href="#" onclick="showSection('history')">Historial</a>
                        <a href="#" onclick="showSection('notifications')">Notificaciones</a>
                    </div>
                    <div class="main-dashboard">
                        <h2>Dashboard Cliente</h2>
                        
                        <div id="private-catalog-section" class="section">
                            <h3>Catálogo Privado</h3>
                            <p>Accede a productos exclusivos para clientes.</p>
                            <div class="catalog-grid">
                                ${products.map(p => `
                                    <div class="card">
                                        <img src="${p.img}" alt="${p.name}">
                                        <h3>${p.name}</h3>
                                        <p>${p.description}</p>
                                        <p><strong>$${p.price}</strong></p>
                                    </div>
                                `).join('')}
                            </div>
                        </div>

                        <div id="service-request-section" class="section hidden">
                            <h3>Solicitar un Servicio</h3>
                            <form onsubmit="submitServiceRequest(event)">
                                <div class="form-group">
                                    <label for="device">Dispositivo (ej: iPhone 13):</label>
                                    <input type="text" id="device" required>
                                </div>
                                <div class="form-group">
                                    <label for="description">Descripción del problema:</label>
                                    <textarea id="description" rows="5" required></textarea>
                                </div>
                                <button type="submit" class="btn">Generar Ticket</button>
                            </form>
                        </div>

                        <div id="service-status-section" class="section hidden">
                            ${serviceProgress}
                            ${activeService && activeService.status !== 'completado' ? `<button class="btn btn-secondary" onclick="confirmCancelService()">Cancelar Solicitud</button>` : ''}
                            ${ratingForm}
                            ${chatInterface}
                        </div>
                        
                        <div id="history-section" class="section hidden">
                            <h3>Historial de Servicios</h3>
                            <button class="btn" onclick="simulatePDFDownload()">Descargar PDF</button>
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th>Dispositivo</th>
                                        <th>Descripción</th>
                                        <th>Estado</th>
                                        <th>Calificación</th>
                                        <th>Comentarios</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${services.filter(s => s.userId === currentUser.id).map(s => `
                                        <tr>
                                            <td>${s.device}</td>
                                            <td>${s.description}</td>
                                            <td>${statusTextMap[s.status]}</td>
                                            <td>${s.rating ? '&#9733;'.repeat(s.rating) : 'N/A'}</td>
                                            <td>${s.comments || 'N/A'}</td>
                                        </tr>
                                    `).join('')}
                                </tbody>
                            </table>
                        </div>
                        
                        <div id="notifications-section" class="section hidden">
                            <h3>Notificaciones</h3>
                            <div class="notifications">
                                <ul>
                                    ${notifications.filter(n => n.role === 'cliente').map(n => `<li>${n.text}</li>`).join('')}
                                </ul>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div id="confirm-cancel-modal" class="modal">
                    <div class="modal-content">
                        <span class="modal-close" onclick="closeModal('confirm-cancel-modal')">&times;</span>
                        <h3>Confirmar Cancelación</h3>
                        <p>¿Estás seguro de que deseas cancelar tu solicitud de servicio?</p>
                        <button class="btn" onclick="cancelService()">Sí, Cancelar</button>
                        <button class="btn btn-secondary" onclick="closeModal('confirm-cancel-modal')">No, Mantener</button>
                    </div>
                </div>
            `;
        }

        function renderTechnicianDashboard() {
            const myServices = services.filter(s => s.technicianId === currentUser.id);
            const pendingServices = services.filter(s => s.status === 'pendiente');
            const history = services.filter(s => s.technicianId === currentUser.id && s.status === 'completado');

            return `
                <div class="dashboard-container">
                    <div class="sidebar">
                        <h2>Menú Técnico</h2>
                        <a href="#" onclick="showSection('pending-requests')">Solicitudes Pendientes</a>
                        <a href="#" onclick="showSection('my-services')">Mis Servicios</a>
                        <a href="#" onclick="showSection('inventory')">Inventario</a>
                        <a href="#" onclick="showSection('technician-history')">Historial</a>
                    </div>
                    <div class="main-dashboard">
                        <h2>Dashboard Técnico</h2>

                        <div id="pending-requests-section" class="section">
                            <h3>Solicitudes Pendientes</h3>
                            <p>Total: ${pendingServices.length}</p>
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Dispositivo</th>
                                        <th>Descripción</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${pendingServices.map(s => `
                                        <tr>
                                            <td>${s.id}</td>
                                            <td>${s.device}</td>
                                            <td>${s.description}</td>
                                            <td><button class="btn" onclick="assignService(${s.id})">Asignar</button></td>
                                        </tr>
                                    `).join('')}
                                </tbody>
                            </table>
                        </div>

                        <div id="my-services-section" class="section hidden">
                            <h3>Mis Servicios Asignados</h3>
                            <div class="service-grid">
                                ${myServices.map(s => `
                                    <div class="card">
                                        <h3>${s.device}</h3>
                                        <p><strong>ID de Servicio:</strong> ${s.id}</p>
                                        <p><strong>Cliente:</strong> ${users.find(u => u.id === s.userId).name}</p>
                                        <p><strong>Descripción:</strong> ${s.description}</p>
                                        <p><strong>Estado:</strong> <span class="${s.status}">${s.status.charAt(0).toUpperCase() + s.status.slice(1).replace('-', ' ')}</span></p>
                                        <div class="actions-cell">
                                            <button class="btn" onclick="showServiceDetails(${s.id})">Ver Detalles</button>
                                        </div>
                                    </div>
                                `).join('')}
                            </div>
                        </div>
                        
                        <div id="service-details-modal" class="modal">
                            <div class="modal-content">
                                <span class="modal-close" onclick="closeModal('service-details-modal')">&times;</span>
                                <div id="service-details-content"></div>
                            </div>
                        </div>

                        <div id="inventory-section" class="section hidden">
                            <h3>Inventario de Refacciones</h3>
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Stock</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${inventory.map(i => `
                                        <tr>
                                            <td>${i.name}</td>
                                            <td>${i.stock}</td>
                                        </tr>
                                    `).join('')}
                                </tbody>
                            </table>
                        </div>
                        
                        <div id="technician-history-section" class="section hidden">
                            <h3>Historial de Servicios Completados</h3>
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th>Dispositivo</th>
                                        <th>Cliente</th>
                                        <th>Calificación</th>
                                        <th>Comentarios</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${history.map(s => `
                                        <tr>
                                            <td>${s.device}</td>
                                            <td>${users.find(u => u.id === s.userId).name}</td>
                                            <td>${s.rating ? '&#9733;'.repeat(s.rating) : 'N/A'}</td>
                                            <td>${s.comments || 'N/A'}</td>
                                        </tr>
                                    `).join('')}
                                </tbody>
                            </table>
                        </div>
                        
                    </div>
                </div>
            `;
        }

        function renderAdminDashboard() {
            const totalServices = services.length;
            const pending = services.filter(s => s.status === 'pendiente').length;
            const inProgress = services.filter(s => s.status === 'en-progreso').length;
            const completed = services.filter(s => s.status === 'completado').length;
            const totalRatings = services.filter(s => s.rating !== null).reduce((sum, s) => sum + s.rating, 0);
            const averageRating = totalRatings / services.filter(s => s.rating !== null).length || 0;

            const serviceStatusTextMap = {
                'pendiente': 'Pendiente',
                'en-progreso': 'En Progreso',
                'completado': 'Completado'
            };

            return `
                <div class="dashboard-container">
                    <div class="sidebar">
                        <h2>Menú Admin</h2>
                        <a href="#" onclick="showSection('stats')">Estadísticas</a>
                        <a href="#" onclick="showSection('users-crud')">Gestión de Usuarios</a>
                        <a href="#" onclick="showSection('products-crud')">Gestión de Productos</a>
                        <a href="#" onclick="showSection('inventory-crud')">Gestión de Inventario</a>
                        <a href="#" onclick="showSection('services-history')">Historial de Servicios</a>
                    </div>
                    <div class="main-dashboard">
                        <h2>Dashboard Administrador</h2>

                        <div id="stats-section" class="section">
                            <h3>Estadísticas Generales</h3>
                            <div class="stats-grid">
                                <div class="stat-card">
                                    <h3>Total Servicios</h3>
                                    <p>${totalServices}</p>
                                </div>
                                <div class="stat-card">
                                    <h3>Pendientes</h3>
                                    <p>${pending}</p>
                                </div>
                                <div class="stat-card">
                                    <h3>En Progreso</h3>
                                    <p>${inProgress}</p>
                                </div>
                                <div class="stat-card">
                                    <h3>Completados</h3>
                                    <p>${completed}</p>
                                </div>
                                <div class="stat-card">
                                    <h3>Calificación Promedio</h3>
                                    <p>${averageRating.toFixed(1)} <span class="star-rating active">&#9733;</span></p>
                                </div>
                            </div>
                            <button class="btn" style="margin-top: 2rem;" onclick="simulatePDFDownload('reporte')">Generar Reporte PDF</button>
                        </div>
                        
                        <div id="users-crud-section" class="section hidden">
                            <h3>Gestión de Usuarios</h3>
                            <button class="btn" onclick="showAddUserModal()">Añadir Usuario</button>
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Correo</th>
                                        <th>Rol</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${users.map(u => `
                                        <tr>
                                            <td>${u.id}</td>
                                            <td>${u.name}</td>
                                            <td>${u.email}</td>
                                            <td>${u.role}</td>
                                            <td class="actions-cell">
                                                <button class="btn" onclick="showEditUserModal(${u.id})">Editar</button>
                                                <button class="btn btn-secondary" onclick="showDeleteModal(${u.id}, 'user')">Eliminar</button>
                                            </td>
                                        </tr>
                                    `).join('')}
                                </tbody>
                            </table>
                        </div>
                        
                        <div id="products-crud-section" class="section hidden">
                            <h3>Gestión de Productos</h3>
                            <button class="btn" onclick="showAddProductModal()">Añadir Producto</button>
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Precio</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${products.map(p => `
                                        <tr>
                                            <td>${p.id}</td>
                                            <td>${p.name}</td>
                                            <td>$${p.price}</td>
                                            <td class="actions-cell">
                                                <button class="btn" onclick="showEditProductModal(${p.id})">Editar</button>
                                                <button class="btn btn-secondary" onclick="showDeleteModal(${p.id}, 'product')">Eliminar</button>
                                            </td>
                                        </tr>
                                    `).join('')}
                                </tbody>
                            </table>
                        </div>
                        
                        <div id="inventory-crud-section" class="section hidden">
                            <h3>Gestión de Inventario</h3>
                            <button class="btn" onclick="showAddInventoryModal()">Añadir Refacción</button>
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Stock</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${inventory.map(i => `
                                        <tr>
                                            <td>${i.name}</td>
                                            <td>${i.stock}</td>
                                            <td class="actions-cell">
                                                <button class="btn" onclick="showEditInventoryModal(${i.id})">Editar</button>
                                                <button class="btn btn-secondary" onclick="showDeleteModal(${i.id}, 'inventory')">Eliminar</button>
                                            </td>
                                        </tr>
                                    `).join('')}
                                </tbody>
                            </table>
                        </div>

                        <div id="services-history-section" class="section hidden">
                            <h3>Historial Completo de Servicios</h3>
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Cliente</th>
                                        <th>Técnico</th>
                                        <th>Dispositivo</th>
                                        <th>Estado</th>
                                        <th>Calificación</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${services.map(s => `
                                        <tr>
                                            <td>${s.id}</td>
                                            <td>${users.find(u => u.id === s.userId).name}</td>
                                            <td>${s.technicianId ? users.find(u => u.id === s.technicianId).name : 'N/A'}</td>
                                            <td>${s.device}</td>
                                            <td>${serviceStatusTextMap[s.status]}</td>
                                            <td>${s.rating ? '&#9733;'.repeat(s.rating) : 'N/A'}</td>
                                        </tr>
                                    `).join('')}
                                </tbody>
                            </table>
                        </div>

                        <div id="crud-modal" class="modal">
                            <div class="modal-content">
                                <span class="modal-close" onclick="closeModal('crud-modal')">&times;</span>
                                <div id="crud-modal-content"></div>
                            </div>
                        </div>

                        <div id="delete-modal" class="modal">
                            <div class="modal-content">
                                <span class="modal-close" onclick="closeModal('delete-modal')">&times;</span>
                                <h3 id="delete-modal-title"></h3>
                                <p id="delete-modal-message"></p>
                                <button class="btn btn-secondary" id="confirm-delete-btn">Eliminar</button>
                                <button class="btn" onclick="closeModal('delete-modal')">Cancelar</button>
                            </div>
                        </div>
                        
                    </div>
                </div>
            `;
        }
        
        // === Lógica de la aplicación (JavaScript) ===
        function renderApp() {
            app.innerHTML = renderHeader();
            if (currentUser) {
                switch (currentUser.role) {
                    case 'cliente':
                        app.innerHTML += renderClientDashboard();
                        break;
                    case 'tecnico':
                        app.innerHTML += renderTechnicianDashboard();
                        break;
                    case 'admin':
                        app.innerHTML += renderAdminDashboard();
                        break;
                }
            } else {
                app.innerHTML += renderPublicCatalog();
                app.innerHTML += renderLoginModal();
            }
        }
        
        function showLoginModal() {
            document.getElementById('login-modal').style.display = 'flex';
        }
        
        function closeModal(id) {
            document.getElementById(id).style.display = 'none';
        }

        function handleLogin(event) {
            event.preventDefault();
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const user = users.find(u => u.email === email && u.password === password);
            const errorElement = document.getElementById('login-error');
            
            if (user) {
                currentUser = user;
                closeModal('login-modal');
                renderApp();
            } else {
                errorElement.classList.remove('hidden');
            }
        }
        
        function handleLogout() {
            currentUser = null;
            renderApp();
        }
        
        function showSection(sectionId) {
            document.querySelectorAll('.section').forEach(section => {
                section.classList.add('hidden');
            });
            document.getElementById(sectionId + '-section').classList.remove('hidden');

            document.querySelectorAll('.sidebar a').forEach(link => {
                link.classList.remove('active');
            });
            document.querySelector(`.sidebar a[onclick="showSection('${sectionId}')"]`).classList.add('active');
        }

        // Cliente
        function submitServiceRequest(event) {
            event.preventDefault();
            const device = document.getElementById('device').value;
            const description = document.getElementById('description').value;

            if (device.trim() === '' || description.trim() === '') {
                alert('Por favor, completa todos los campos.');
                return;
            }

            const newService = {
                id: services.length + 1,
                userId: currentUser.id,
                device,
                description,
                status: 'pendiente',
                technicianId: null,
                diagnostic: null,
                rating: null,
                comments: null
            };
            services.push(newService);
            alert('Tu solicitud ha sido generada con éxito.');
            renderApp();
            showSection('service-status');
        }

        function confirmCancelService() {
            document.getElementById('confirm-cancel-modal').style.display = 'flex';
        }

        function cancelService() {
            if (activeService) {
                const index = services.findIndex(s => s.id === activeService.id);
                if (index > -1) {
                    services.splice(index, 1);
                    activeService = null;
                    closeModal('confirm-cancel-modal');
                    alert('La solicitud ha sido cancelada.');
                    renderApp();
                }
            }
        }
        
        function highlightStars(element) {
            const rating = element.dataset.rating;
            const stars = document.getElementById('star-rating-container').children;
            for (let i = 0; i < stars.length; i++) {
                if (i < rating) {
                    stars[i].classList.add('hover');
                } else {
                    stars[i].classList.remove('hover');
                }
            }
        }
        
        function resetStars(element) {
            const stars = document.getElementById('star-rating-container').children;
            for (let i = 0; i < stars.length; i++) {
                stars[i].classList.remove('hover');
            }
        }
        
        function rateService(rating) {
            if (activeService) {
                activeService.rating = rating;
                renderApp(); // Re-render para mostrar la calificación guardada
            }
        }

        function submitComment(event) {
            event.preventDefault();
            if (activeService) {
                const comment = document.getElementById('comment').value;
                activeService.comments = comment;
                alert('Comentarios enviados. ¡Gracias!');
                renderApp();
            }
        }
        
        function sendMessage() {
            const input = document.getElementById('chat-input');
            const message = input.value.trim();
            if (message === '') return;

            const chat = chats.find(c => c.serviceId === (activeService ? activeService.id : null));
            if (chat) {
                chat.messages.push({ sender: 'cliente', text: message });
                const messagesContainer = document.getElementById('chat-messages');
                messagesContainer.innerHTML += `
                    <div class="chat-message me">${message}</div>
                `;
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
                input.value = '';
            }
        }

        function simulatePDFDownload(type = 'historial') {
            alert(`Simulando la descarga de un PDF de ${type}...`);
        }

        // Técnico
        function assignService(serviceId) {
            const service = services.find(s => s.id === serviceId);
            if (service) {
                service.technicianId = currentUser.id;
                service.status = 'en-progreso';
                alert('Servicio asignado a tu lista.');
                renderApp();
                showSection('my-services');
            }
        }
        
        function showServiceDetails(serviceId) {
            const service = services.find(s => s.id === serviceId);
            const chat = chats.find(c => c.serviceId === serviceId);
            const statusMap = { 'pendiente': 'Pendiente', 'en-progreso': 'En Progreso', 'completado': 'Completado' };
            const nextStatusMap = { 'pendiente': 'en-progreso', 'en-progreso': 'completado' };

            let chatInterface = '';
            if (chat) {
                chatInterface = `
                    <div class="chat-container" style="height: 300px;">
                        <h3>Chat con Cliente</h3>
                        <div class="chat-messages" id="details-chat-messages">
                            ${chat.messages.map(m => `
                                <div class="chat-message ${m.sender === 'tecnico' ? 'me' : 'other'}">
                                    ${m.text}
                                </div>
                            `).join('')}
                        </div>
                        <div class="chat-input">
                            <input type="text" id="details-chat-input" placeholder="Escribe un mensaje...">
                            <button class="btn" onclick="sendDetailsMessage(${service.id})">Enviar</button>
                        </div>
                    </div>
                `;
            }

            const content = `
                <h3>Detalles del Servicio ID: ${service.id}</h3>
                <p><strong>Dispositivo:</strong> ${service.device}</p>
                <p><strong>Descripción:</strong> ${service.description}</p>
                <p><strong>Estado Actual:</strong> ${statusMap[service.status]}</p>
                
                ${service.status !== 'completado' ? `
                    <form onsubmit="updateServiceStatus(event, ${service.id})">
                        <div class="form-group">
                            <label for="diagnostic">Diagnóstico:</label>
                            <textarea id="diagnostic" rows="3">${service.diagnostic || ''}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="status-update">Actualizar Estado:</label>
                            <select id="status-update">
                                <option value="${nextStatusMap[service.status]}">${statusMap[nextStatusMap[service.status]]}</option>
                                <option value="completado">Completado</option>
                            </select>
                        </div>
                        <button type="submit" class="btn">Actualizar</button>
                    </form>
                ` : `
                    <p><strong>Diagnóstico:</strong> ${service.diagnostic}</p>
                    <p><strong>Calificación:</strong> ${service.rating ? '&#9733;'.repeat(service.rating) : 'N/A'}</p>
                    <p><strong>Comentarios:</strong> ${service.comments || 'N/A'}</p>
                `}
                ${chatInterface}
            `;
            document.getElementById('service-details-content').innerHTML = content;
            document.getElementById('service-details-modal').style.display = 'flex';
        }
        
        function updateServiceStatus(event, serviceId) {
            event.preventDefault();
            const service = services.find(s => s.id === serviceId);
            if (service) {
                const newStatus = document.getElementById('status-update').value;
                const diagnostic = document.getElementById('diagnostic').value;
                
                service.status = newStatus;
                service.diagnostic = diagnostic;
                
                alert('Servicio actualizado correctamente.');
                closeModal('service-details-modal');
                renderApp();
                showSection('my-services');
            }
        }
        
        function sendDetailsMessage(serviceId) {
            const input = document.getElementById('details-chat-input');
            const message = input.value.trim();
            if (message === '') return;

            const chat = chats.find(c => c.serviceId === serviceId);
            if (chat) {
                chat.messages.push({ sender: 'tecnico', text: message });
                const messagesContainer = document.getElementById('details-chat-messages');
                messagesContainer.innerHTML += `
                    <div class="chat-message me">${message}</div>
                `;
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
                input.value = '';
            }
        }
        
        // Administrador
        function showCRUDModal(type, data = {}) {
            let title = '';
            let formContent = '';
            let formAction = '';

            switch(type) {
                case 'addUser':
                    title = 'Añadir Usuario';
                    formContent = `
                        <div class="form-group">
                            <label for="name">Nombre:</label>
                            <input type="text" id="name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Usuario:</label>
                            <input type="text" id="email" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Contraseña:</label>
                            <input type="text" id="password" required>
                        </div>
                        <div class="form-group">
                            <label for="role">Rol:</label>
                            <select id="role">
                                <option value="cliente">Cliente</option>
                                <option value="tecnico">Técnico</option>
                                <option value="admin">Administrador</option>
                            </select>
                        </div>
                    `;
                    formAction = `addUser()`;
                    break;
                case 'editUser':
                    title = 'Editar Usuario';
                    formContent = `
                        <input type="hidden" id="userId" value="${data.id}">
                        <div class="form-group">
                            <label for="name">Nombre:</label>
                            <input type="text" id="name" value="${data.name}" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Usuario:</label>
                            <input type="text" id="email" value="${data.email}" required>
                        </div>
                        <div class="form-group">
                            <label for="role">Rol:</label>
                            <select id="role">
                                <option value="cliente" ${data.role === 'cliente' ? 'selected' : ''}>Cliente</option>
                                <option value="tecnico" ${data.role === 'tecnico' ? 'selected' : ''}>Técnico</option>
                                <option value="admin" ${data.role === 'admin' ? 'selected' : ''}>Administrador</option>
                            </select>
                        </div>
                    `;
                    formAction = `editUser()`;
                    break;
                case 'addProduct':
                    title = 'Añadir Producto';
                    formContent = `
                        <div class="form-group">
                            <label for="name">Nombre:</label>
                            <input type="text" id="name" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Descripción:</label>
                            <textarea id="description" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="price">Precio:</label>
                            <input type="number" id="price" required>
                        </div>
                        <div class="form-group">
                            <label for="img">URL de Imagen:</label>
                            <input type="text" id="img" value="https://placehold.co/400x400/dc2626/ffffff?text=Producto" required>
                        </div>
                    `;
                    formAction = `addProduct()`;
                    break;
                case 'editProduct':
                    title = 'Editar Producto';
                    formContent = `
                        <input type="hidden" id="productId" value="${data.id}">
                        <div class="form-group">
                            <label for="name">Nombre:</label>
                            <input type="text" id="name" value="${data.name}" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Descripción:</label>
                            <textarea id="description" required>${data.description}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="price">Precio:</label>
                            <input type="number" id="price" value="${data.price}" required>
                        </div>
                    `;
                    formAction = `editProduct()`;
                    break;
                case 'addInventory':
                    title = 'Añadir Refacción';
                    formContent = `
                        <div class="form-group">
                            <label for="name">Nombre:</label>
                            <input type="text" id="name" required>
                        </div>
                        <div class="form-group">
                            <label for="stock">Stock:</label>
                            <input type="number" id="stock" required>
                        </div>
                    `;
                    formAction = `addInventory()`;
                    break;
                case 'editInventory':
                    title = 'Editar Refacción';
                    formContent = `
                        <input type="hidden" id="inventoryId" value="${data.id}">
                        <div class="form-group">
                            <label for="name">Nombre:</label>
                            <input type="text" id="name" value="${data.name}" required>
                        </div>
                        <div class="form-group">
                            <label for="stock">Stock:</label>
                            <input type="number" id="stock" value="${data.stock}" required>
                        </div>
                    `;
                    formAction = `editInventory()`;
                    break;
            }

            const modalContent = `
                <h3>${title}</h3>
                <form onsubmit="event.preventDefault(); ${formAction};">
                    ${formContent}
                    <button type="submit" class="btn">Guardar</button>
                    <button type="button" class="btn btn-secondary" onclick="closeModal('crud-modal')">Cancelar</button>
                </form>
            `;
            document.getElementById('crud-modal-content').innerHTML = modalContent;
            document.getElementById('crud-modal').style.display = 'flex';
        }
        
        function showAddUserModal() { showCRUDModal('addUser'); }
        function showEditUserModal(id) { const user = users.find(u => u.id === id); showCRUDModal('editUser', user); }
        function showAddProductModal() { showCRUDModal('addProduct'); }
        function showEditProductModal(id) { const product = products.find(p => p.id === id); showCRUDModal('editProduct', product); }
        function showAddInventoryModal() { showCRUDModal('addInventory'); }
        function showEditInventoryModal(id) { const item = inventory.find(i => i.id === id); showCRUDModal('editInventory', item); }
        
        function addUser() {
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const role = document.getElementById('role').value;
            const newUser = { id: users.length + 1, name, email, password, role };
            users.push(newUser);
            alert('Usuario añadido con éxito.');
            closeModal('crud-modal');
            renderApp();
            showSection('users-crud');
        }
        
        function editUser() {
            const id = parseInt(document.getElementById('userId').value);
            const user = users.find(u => u.id === id);
            if (user) {
                user.name = document.getElementById('name').value;
                user.email = document.getElementById('email').value;
                user.role = document.getElementById('role').value;
                alert('Usuario actualizado con éxito.');
                closeModal('crud-modal');
                renderApp();
                showSection('users-crud');
            }
        }
        
        function addProduct() {
            const name = document.getElementById('name').value;
            const description = document.getElementById('description').value;
            const price = parseFloat(document.getElementById('price').value);
            const img = document.getElementById('img').value;
            const newProduct = { id: products.length + 1, name, description, price, img };
            products.push(newProduct);
            alert('Producto añadido con éxito.');
            closeModal('crud-modal');
            renderApp();
            showSection('products-crud');
        }
        
        function editProduct() {
            const id = parseInt(document.getElementById('productId').value);
            const product = products.find(p => p.id === id);
            if (product) {
                product.name = document.getElementById('name').value;
                product.description = document.getElementById('description').value;
                product.price = parseFloat(document.getElementById('price').value);
                alert('Producto actualizado con éxito.');
                closeModal('crud-modal');
                renderApp();
                showSection('products-crud');
            }
        }
        
        function addInventory() {
            const name = document.getElementById('name').value;
            const stock = parseInt(document.getElementById('stock').value);
            const newInventory = { id: inventory.length + 1, name, stock };
            inventory.push(newInventory);
            alert('Refacción añadida con éxito.');
            closeModal('crud-modal');
            renderApp();
            showSection('inventory-crud');
        }
        
        function editInventory() {
            const id = parseInt(document.getElementById('inventoryId').value);
            const item = inventory.find(i => i.id === id);
            if (item) {
                item.name = document.getElementById('name').value;
                item.stock = parseInt(document.getElementById('stock').value);
                alert('Refacción actualizada con éxito.');
                closeModal('crud-modal');
                renderApp();
                showSection('inventory-crud');
            }
        }
        
        let itemToDelete = null;
        let itemTypeToDelete = '';

        function showDeleteModal(id, type) {
            itemToDelete = id;
            itemTypeToDelete = type;
            document.getElementById('delete-modal-title').innerText = `Eliminar ${type === 'user' ? 'Usuario' : type === 'product' ? 'Producto' : 'Refacción'}`;
            document.getElementById('delete-modal-message').innerText = `¿Estás seguro de que deseas eliminar este ${type}?`;
            document.getElementById('confirm-delete-btn').onclick = confirmDelete;
            document.getElementById('delete-modal').style.display = 'flex';
        }
        
        function confirmDelete() {
            if (itemToDelete !== null && itemTypeToDelete !== '') {
                switch(itemTypeToDelete) {
                    case 'user':
                        const userIndex = users.findIndex(u => u.id === itemToDelete);
                        if (userIndex > -1) { users.splice(userIndex, 1); }
                        alert('Usuario eliminado.');
                        showSection('users-crud');
                        break;
                    case 'product':
                        const productIndex = products.findIndex(p => p.id === itemToDelete);
                        if (productIndex > -1) { products.splice(productIndex, 1); }
                        alert('Producto eliminado.');
                        showSection('products-crud');
                        break;
                    case 'inventory':
                        const inventoryIndex = inventory.findIndex(i => i.id === itemToDelete);
                        if (inventoryIndex > -1) { inventory.splice(inventoryIndex, 1); }
                        alert('Refacción eliminada.');
                        showSection('inventory-crud');
                        break;
                }
                closeModal('delete-modal');
                renderApp();
                itemToDelete = null;
                itemTypeToDelete = '';
            }
        }
        
        // Inicialización
        renderApp();
