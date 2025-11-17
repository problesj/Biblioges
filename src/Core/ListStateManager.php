<?php

namespace App\Core;

class ListStateManager
{
    private $session;
    private $listName;

    public function __construct(Session $session, string $listName)
    {
        $this->session = $session;
        $this->listName = $listName;
    }

    /**
     * Obtiene los parámetros del estado del listado desde la sesión o URL
     */
    public function getState(array $urlParams = []): array
    {
        $sessionKey = "list_state_{$this->listName}";
        $savedState = $this->session->get($sessionKey, []);
        
        // Verificar si han cambiado los filtros (excluyendo paginación y ordenamiento)
        $filtersChanged = $this->haveFiltersChanged($savedState, $urlParams);
        
        // Si los filtros cambiaron, resetear la paginación
        if ($filtersChanged) {
            unset($savedState['page']);
            unset($savedState['per_page']);
        }
        
        // Combinar estado guardado con parámetros de URL
        $state = array_merge($savedState, $urlParams);
        
        // Validar y establecer valores por defecto
        return $this->validateState($state);
    }

    /**
     * Guarda el estado actual en la sesión
     */
    public function saveState(array $state): void
    {
        $sessionKey = "list_state_{$this->listName}";
        $this->session->set($sessionKey, $state);
    }

    /**
     * Limpia el estado guardado
     */
    public function clearState(): void
    {
        $sessionKey = "list_state_{$this->listName}";
        $this->session->remove($sessionKey);
    }

    /**
     * Valida y establece valores por defecto para el estado
     */
    private function validateState(array $state): array
    {
        // Valores por defecto según el tipo de listado
        $defaults = $this->getDefaults();
        
        // Asegurar que todas las claves existan
        $state = array_merge($defaults, $state);
        
        // Validar paginación
        $state['page'] = max(1, intval($state['page']));
        $state['per_page'] = in_array($state['per_page'], $defaults['allowed_per_page']) 
            ? intval($state['per_page']) 
            : $defaults['per_page'];

        // Validar ordenamiento
        $state['sort'] = in_array($state['sort'], $defaults['allowed_columns']) 
            ? $state['sort'] 
            : $defaults['sort'];
        $state['direction'] = in_array(strtoupper($state['direction']), ['ASC', 'DESC']) 
            ? strtoupper($state['direction']) 
            : $defaults['direction'];

        // Validar filtros
        foreach ($defaults['filters'] as $filterKey => $defaultValue) {
            if (!isset($state[$filterKey])) {
                $state[$filterKey] = $defaultValue;
            }
        }

        return $state;
    }

    /**
     * Obtiene los valores por defecto según el tipo de listado
     */
    private function getDefaults(): array
    {
        $defaults = [
            'page' => 1,
            'per_page' => 10,
            'allowed_per_page' => [5, 10, 15, 20],
            'sort' => 'nombre',
            'direction' => 'ASC',
            'allowed_columns' => ['nombre', 'tipo_programa', 'estado', 'cantidad_semestres', 'sede'],
            'filters' => [
                'nombre' => '',
                'tipo_programa' => '',
                'sede' => '',
                'estado' => ''
            ]
        ];

        // Personalizar según el tipo de listado
        switch ($this->listName) {
            case 'carreras':
                $defaults['sort'] = 'nombre';
                $defaults['allowed_columns'] = ['nombre', 'tipo_programa', 'estado', 'cantidad_semestres', 'sede'];
                $defaults['filters'] = [
                    'nombre' => '',
                    'tipo_programa' => '',
                    'sede' => '',
                    'estado' => ''
                ];
                break;

            case 'asignaturas':
                $defaults['sort'] = 'nombre';
                $defaults['allowed_columns'] = ['nombre', 'tipo', 'estado', 'periodicidad', 'unidad'];
                $defaults['filters'] = [
                    'nombre' => '',
                    'codigo' => '',
                    'tipo' => '',
                    'unidad' => '',
                    'estado' => ''
                ];
                break;

            case 'bibliografias':
                $defaults['sort'] = 'titulo';
                $defaults['allowed_columns'] = ['titulo', 'tipo', 'estado', 'autores', 'asignaturas', 'anio_publicacion'];
                $defaults['filters'] = [
                    'busqueda' => '',
                    'tipo_busqueda' => 'todos',
                    'tipo' => '',
                    'estado' => ''
                ];
                break;

            case 'bibliografias_declaradas':
                $defaults['sort'] = 'titulo';
                $defaults['allowed_columns'] = ['titulo', 'tipo', 'estado', 'autores', 'asignaturas', 'anio_publicacion'];
                $defaults['filters'] = [
                    'busqueda' => '',
                    'tipo_busqueda' => 'todos',
                    'tipo' => '',
                    'estado' => ''
                ];
                break;

            case 'bibliografias_disponibles':
                $defaults['sort'] = 'titulo';
                $defaults['allowed_columns'] = ['titulo', 'editorial', 'autores'];
                $defaults['filters'] = [
                    'busqueda' => '',
                    'disponibilidad' => '',
                    'estado' => '',
                    'anio_edicion' => ''
                ];
                break;

            case 'reporte_coberturas':
                $defaults['sort'] = 'sede';
                $defaults['allowed_columns'] = ['sede', 'codigo', 'nombre', 'tipo_programa', 'estado', 'cobertura_basica', 'cobertura_complementaria'];
                $defaults['filters'] = [
                    'sede' => '',
                    'tipo_programa' => '',
                    'estado' => '',
                    'nombre' => ''
                ];
                break;

            case 'reporte_bibliografias':
                $defaults['sort'] = 'titulo';
                $defaults['allowed_columns'] = ['titulo', 'autores', 'anio_publicacion', 'editorial', 'tipo', 'estado', 'num_asignaturas', 'num_bibliografias_disponibles', 'tipos_bibliografias'];
                $defaults['filters'] = [
                    'busqueda' => '',
                    'tipo_busqueda' => 'todos',
                    'estado' => '',
                    'tipo' => '',
                    'tipo_bibliografia' => '',
                    'bibliografias_disponibles' => '',
                    'carrera_id' => ''
                ];
                break;

            case 'tareas_programadas':
                $defaults['sort'] = 'fecha_programada';
                $defaults['direction'] = 'DESC';
                $defaults['allowed_columns'] = ['id', 'nombre', 'tipo_reporte', 'sede_nombre', 'carrera_nombre', 'fecha_programada', 'estado', 'fecha_creacion'];
                $defaults['filters'] = [
                    'search' => '',
                    'tipo_reporte' => '',
                    'estado' => ''
                ];
                break;

            case 'reportes_coberturas':
                $defaults['sort'] = 'nombre';
                $defaults['allowed_columns'] = ['nombre', 'tipo_programa', 'estado', 'sede'];
                $defaults['filters'] = [
                    'sede' => '',
                    'tipo_programa' => '',
                    'estado' => '',
                    'nombre' => ''
                ];
                break;
        }

        return $defaults;
    }

    /**
     * Construye la URL con los parámetros del estado
     */
    public function buildUrl(array $additionalParams = []): string
    {
        $state = $this->getState();
        $params = array_merge($state, $additionalParams);
        
        // Solo incluir parámetros necesarios para la URL
        $urlParams = [
            'page' => $params['page'],
            'per_page' => $params['per_page'],
            'sort' => $params['sort'],
            'direction' => $params['direction']
        ];
        
        // Agregar filtros activos
        foreach ($this->getDefaults()['filters'] as $filterKey => $defaultValue) {
            if (isset($params[$filterKey]) && $params[$filterKey] !== $defaultValue && $params[$filterKey] !== '') {
                $urlParams[$filterKey] = $params[$filterKey];
            }
        }
        
        // Agregar parámetros adicionales
        foreach ($additionalParams as $key => $value) {
            if ($value !== '' && $value !== null) {
                $urlParams[$key] = $value;
            }
        }

        return '?' . http_build_query($urlParams);
    }

    /**
     * Construye URL limpia con solo los parámetros necesarios
     */
    public function buildCleanUrl(array $params = []): string
    {
        $state = $this->getState();
        $allParams = array_merge($state, $params);
        
        // Solo incluir parámetros esenciales
        $urlParams = [];
        
        // Agregar parámetros de paginación y ordenamiento
        if (isset($allParams['page']) && $allParams['page'] > 1) {
            $urlParams['page'] = $allParams['page'];
        }
        if (isset($allParams['per_page']) && $allParams['per_page'] != 10) {
            $urlParams['per_page'] = $allParams['per_page'];
        }
        if (isset($allParams['sort']) && $allParams['sort'] != 'nombre') {
            $urlParams['sort'] = $allParams['sort'];
        }
        if (isset($allParams['direction']) && $allParams['direction'] != 'ASC') {
            $urlParams['direction'] = $allParams['direction'];
        }
        
        // Agregar filtros activos
        foreach ($this->getDefaults()['filters'] as $filterKey => $defaultValue) {
            if (isset($allParams[$filterKey]) && $allParams[$filterKey] !== $defaultValue && $allParams[$filterKey] !== '') {
                $urlParams[$filterKey] = $allParams[$filterKey];
            }
        }

        return empty($urlParams) ? '' : '?' . http_build_query($urlParams);
    }

    /**
     * Construye URL para ordenamiento
     */
    public function buildSortUrl(string $column, array $additionalParams = []): string
    {
        $state = $this->getState();
        
        // Cambiar dirección si es la misma columna
        if ($state['sort'] === $column) {
            $state['direction'] = $state['direction'] === 'ASC' ? 'DESC' : 'ASC';
        } else {
            $state['sort'] = $column;
            $state['direction'] = 'ASC';
        }

        // Resetear a página 1 al cambiar ordenamiento
        $state['page'] = 1;

        return $this->buildCleanUrl(array_merge($state, $additionalParams));
    }

    /**
     * Construye URL para cambio de página
     */
    public function buildPageUrl(int $page, array $additionalParams = []): string
    {
        $state = $this->getState();
        $state['page'] = $page;

        return $this->buildCleanUrl(array_merge($state, $additionalParams));
    }

    /**
     * Construye URL para cambio de registros por página
     */
    public function buildPerPageUrl(int $perPage, array $additionalParams = []): string
    {
        $state = $this->getState();
        $state['per_page'] = $perPage;
        $state['page'] = 1; // Resetear a página 1

        return $this->buildCleanUrl(array_merge($state, $additionalParams));
    }

    /**
     * Obtiene el ícono de ordenamiento para una columna
     */
    public function getSortIcon(string $column): string
    {
        $state = $this->getState();
        
        if ($state['sort'] !== $column) {
            return 'fa-sort';
        }
        
        return $state['direction'] === 'ASC' ? 'fa-sort-up' : 'fa-sort-down';
    }

    /**
     * Verifica si hay filtros activos
     */
    public function hasActiveFilters(): bool
    {
        $state = $this->getState();
        $defaults = $this->getDefaults();
        
        foreach ($defaults['filters'] as $filterKey => $defaultValue) {
            if (isset($state[$filterKey]) && $state[$filterKey] !== $defaultValue) {
                return true;
            }
        }
        
        return false;
    }

    /**
     * Obtiene los filtros activos
     */
    public function getActiveFilters(): array
    {
        $state = $this->getState();
        $defaults = $this->getDefaults();
        $activeFilters = [];
        
        foreach ($defaults['filters'] as $filterKey => $defaultValue) {
            if (isset($state[$filterKey]) && $state[$filterKey] !== $defaultValue) {
                $activeFilters[$filterKey] = $state[$filterKey];
            }
        }
        
        return $activeFilters;
    }

    /**
     * Verifica si han cambiado los filtros (excluyendo paginación y ordenamiento)
     */
    private function haveFiltersChanged(array $savedState, array $urlParams): bool
    {
        $defaults = $this->getDefaults();
        
        foreach ($defaults['filters'] as $filterKey => $defaultValue) {
            $savedValue = $savedState[$filterKey] ?? $defaultValue;
            $urlValue = $urlParams[$filterKey] ?? $defaultValue;
            
            // Comparar valores, considerando que cadenas vacías y null son equivalentes
            $savedValue = $savedValue === '' ? null : $savedValue;
            $urlValue = $urlValue === '' ? null : $urlValue;
            
            if ($savedValue !== $urlValue) {
                return true;
            }
        }
        
        return false;
    }
}
